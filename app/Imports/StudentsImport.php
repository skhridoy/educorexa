<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\User;
use App\Models\AcademicYear;
use App\Models\Classes;
use App\Models\Section;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Exception;

class StudentsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $schoolId = Auth::user()->school_id;
        $academicYear = AcademicYear::where('school_id', $schoolId)->where('is_active', 1)->first();

        if (!$academicYear) {
            throw new Exception('No active academic year found.');
        }

        $yearPart = substr($academicYear->name, -2);
        $prefix = 'STD-' . $yearPart;

        // ১. ডাটাবেজ থেকে বর্তমান সর্বোচ্চ সিরিয়াল নম্বরটি একবারই নিয়ে আসা
        $lastSerial = Student::where('school_id', $schoolId)
            ->where('student_id', 'like', $prefix . '%')
            ->selectRaw("MAX(CAST(SUBSTRING(student_id, -4) AS UNSIGNED)) as max_serial")
            ->value('max_serial');

        $currentNextNumber = $lastSerial ? $lastSerial + 1 : 1001;

        // ২. সব ক্লাসের ব্যবহৃত রোলগুলো লোড করা
        $usedRolls = [];
        $classIds = $rows->pluck('class')->unique();
        
        foreach($classIds as $id) {
            $usedRolls[$id] = Student::where('school_id', $schoolId)
                ->where('class_id', $id)
                ->where('academic_year_id', $academicYear->id)
                ->pluck('roll')
                ->toArray();

            // এক্সেলের ম্যানুয়াল রোলগুলোকেও ব্যবহৃত তালিকায় রাখা
            $excelManualRolls = $rows->where('class', $id)->pluck('roll')->filter()->toArray();
            $usedRolls[$id] = array_unique(array_merge($usedRolls[$id], $excelManualRolls));
        }

        foreach ($rows as $row) {
            $class = Classes::where('id', $row['class'])->where('school_id', $schoolId)->first();
            if (!$class) continue;

            $classId = $class->id;

            // ৩. রোল নির্ধারণ (গ্যাপ ফিলিং লজিক)
            $finalRoll = null;
            if (isset($row['roll']) && !empty($row['roll'])) {
                $finalRoll = (int)$row['roll'];
            } else {
                $suggestedRoll = 1;
                while (in_array($suggestedRoll, $usedRolls[$classId])) {
                    $suggestedRoll++;
                }
                $finalRoll = $suggestedRoll;
                $usedRolls[$classId][] = $finalRoll; // লুপের পরের জনের জন্য বুক করে রাখা
            }

            // ৪. স্টুডেন্ট আইডি জেনারেশন (লুপের ভেতরে ডাইনামিকালি ইনক্রিমেন্ট)
            $studentId = $prefix . str_pad($currentNextNumber, 4, '0', STR_PAD_LEFT);
            $currentNextNumber++; // পরবর্তী স্টুডেন্টের জন্য ১ বাড়িয়ে রাখা

            // ৫. ডিফল্ট সেকশন হ্যান্ডেলিং (যদি এক্সেলে না থাকে)
            $sectionId = $row['section'] ?? null;
            if (!$sectionId) {
                $defaultSection = Section::where('school_id', $schoolId)->where('class_id', $classId)->first();
                $sectionId = $defaultSection ? $defaultSection->id : null;
            }

            // ৬. ট্রানজ্যাকশন ব্যবহার করা ভালো যাতে এরর হলে ডাটা অসম্পূর্ণ না থাকে
            DB::transaction(function () use ($row, $schoolId, $academicYear, $classId, $sectionId, $studentId, $finalRoll) {
                
                // ইউজার অ্যাকাউন্ট
                $user = User::updateOrCreate(
                    ['email' => $studentId . '@gmail.com'], // ডোমেইন পরিবর্তন করতে পারেন
                    [
                        'school_id' => $schoolId,
                        'name'      => $row['name'],
                        'password'  => Hash::make($row['password'] ?? '12345678'),
                        'role'      => 'student',
                    ]
                );

                if (method_exists($user, 'assignRole')) {
                    $user->assignRole('student');
                }

                // স্টুডেন্ট তৈরি
                Student::create([
                    'user_id'           => $user->id,
                    'school_id'         => $schoolId,
                    'academic_year_id'  => $academicYear->id,
                    'class_id'          => $classId,
                    'section_id'        => $sectionId,
                    'student_id'        => $studentId,
                    'roll'              => $finalRoll,
                    'name'              => $row['name'],
                    'fathers_name'      => $row['fathers_name'] ?? null,
                    'mothers_name'      => $row['mothers_name'] ?? null,
                    'contact_number'    => $row['contact_number'] ?? null,
                    'date_of_birth'     => isset($row['date_of_birth']) ? (is_numeric($row['date_of_birth']) ? Date::excelToDateTimeObject($row['date_of_birth'])->format('Y-m-d') : $row['date_of_birth']) : null,
                    'gender'            => $row['gender'] ?? null,
                    'blood_group'       => $row['blood_group'] ?? null,
                    'religion'          => $row['religion'] ?? null,
                    'address'           => $row['address'] ?? null,
                    'password'          => Hash::make($row['password'] ?? '12345678'),
                    'status'            => 'active',
                    'created_by'        => Auth::id(),
                ]);
            });
        }
    }
}