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

        // বর্তমান সর্বোচ্চ সিরিয়াল নম্বর বের করা
        $lastSerial = Student::where('school_id', $schoolId)
            ->where('student_id', 'like', $prefix . '%')
            ->selectRaw("MAX(CAST(SUBSTRING(student_id, -4) AS UNSIGNED)) as max_serial")
            ->value('max_serial');

        $currentNextNumber = $lastSerial ? $lastSerial + 1 : 1001;

        // রোল ট্র্যাকিংয়ের জন্য খালি অ্যারে
        $usedRolls = [];

        foreach ($rows as $row) {
            // ১. Class Code দিয়ে ক্লাস খুঁজে বের করা (আপনার ইমেজে দেখা যাচ্ছে 01, 09 ইত্যাদি কোড আছে)
            // এক্সেলে কলামের নাম দিবেন 'class_code'
            $excelCode = str_pad(trim($row['class_code']), 2, '0', STR_PAD_LEFT);
            
            $class = Classes::where('school_id', $schoolId)
                            ->where('code', $excelCode)
                            ->first();

            if (!$class) continue; 

            $classId = $class->id;
            $categoryId = $class->school_category_id; 
            
            
            // এক্সেলে কলামের নাম 'sub_category_id' থাকতে হবে
            $subCategoryId = isset($row['sub_category_id']) && !empty($row['sub_category_id']) 
                            ? $row['sub_category_id'] 
                            : null;

            // ২. বিদ্যমান রোল নম্বরগুলো চেক করা (যদি আগে লোড করা না থাকে)
            if (!isset($usedRolls[$classId])) {
                $usedRolls[$classId] = Student::where('school_id', $schoolId)
                    ->where('class_id', $classId)
                    ->where('academic_year_id', $academicYear->id)
                    ->pluck('roll')
                    ->toArray();
            }

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
                $usedRolls[$classId][] = $finalRoll; 
            }

            // ৪. স্টুডেন্ট আইডি জেনারেশন
            $studentId = $prefix . str_pad($currentNextNumber, 4, '0', STR_PAD_LEFT);
            $currentNextNumber++;

            // ৫. সেকশন নির্ধারণ (এক্সেলে থাকলে ভালো, নাহলে ডিফল্ট প্রথম সেকশন)
            $sectionId = $row['section'] ?? null;
            if (!$sectionId) {
                $defaultSection = Section::where('school_id', $schoolId)->where('class_id', $classId)->first();
                $sectionId = $defaultSection ? $defaultSection->id : null;
            }

            // ৬. ট্রানজ্যাকশন ব্যবহার করে ডাটা সেভ
            DB::transaction(function () use ($row, $schoolId, $academicYear, $class, $categoryId, $subCategoryId, $sectionId, $studentId, $finalRoll) {
                
                $user = User::updateOrCreate(
                    ['email' => $studentId . '@gmail.com'], 
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

                Student::create([
                    'user_id'                => $user->id,
                    'school_id'              => $schoolId,
                    'academic_year_id'       => $academicYear->id,
                    'school_category_id'     => $categoryId,    // Classes টেবিল থেকে প্রাপ্ত
                    'school_sub_category_id' => $subCategoryId,
                    'class_id'               => $class->id,
                    'section_id'             => $sectionId,
                    'student_id'             => $studentId,
                    'roll'                   => $finalRoll,
                    'name'                   => $row['name'],
                    'fathers_name'           => $row['fathers_name'] ?? null,
                    'mothers_name'           => $row['mothers_name'] ?? null,
                    'contact_number'         => $row['contact_number'] ?? null,
                    'date_of_birth'          => isset($row['date_of_birth']) ? (is_numeric($row['date_of_birth']) ? Date::excelToDateTimeObject($row['date_of_birth'])->format('Y-m-d') : $row['date_of_birth']) : null,
                    'gender'                 => $row['gender'] ?? null,
                    'blood_group'            => $row['blood_group'] ?? null,
                    'religion'               => $row['religion'] ?? null,
                    'address'                => $row['address'] ?? null,
                    'password'               => Hash::make($row['password'] ?? '12345678'),
                    'status'                 => 'active',
                    'created_by'             => Auth::id(),
                ]);
            });
        }
    }
}
