<?php

namespace App\Imports;

use App\Models\Teacher;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class TeacherImport implements ToModel, WithHeadingRow, SkipsOnError, WithBatchInserts, WithChunkReading
{
    use SkipsErrors;

    protected int $schoolId;
    public int $importedCount = 0;
    public int $skippedCount  = 0;
    public array $skippedRows  = [];

    public function __construct(int $schoolId)
    {
        $this->schoolId = $schoolId;
    }

    /**
     * Column headers expected in Excel (row 1):
     *   name | email | phone | gender | subject_name | date_of_birth | father_name | mother_name | nid | blood_group | joining_date | qualification | address
     */
    public function model(array $row): ?Teacher
    {
        // Skip completely empty rows
        if (empty(trim((string) ($row['name'] ?? '')))) {
            return null;
        }

        // Duplicate email / phone / nid check
        $email = trim($row['email'] ?? '');
        $phone = trim($row['phone'] ?? '');
        $nid   = trim($row['nid']   ?? '');

        if ($email && User::where('email', $email)->exists()) {
            $this->skippedCount++;
            $this->skippedRows[] = "ইমেইল ইতিমধ্যে আছে: {$email}";
            return null;
        }

        if ($phone && Teacher::where('phone', $phone)->exists()) {
            $this->skippedCount++;
            $this->skippedRows[] = "ফোন নম্বর ইতিমধ্যে আছে: {$phone}";
            return null;
        }

        if ($nid && Teacher::where('nid', $nid)->exists()) {
            $this->skippedCount++;
            $this->skippedRows[] = "NID ইতিমধ্যে আছে: {$nid}";
            return null;
        }

        // Resolve subject_id from subject name
        $subjectName = trim($row['subject_name'] ?? '');
        $subject     = Subject::where('school_id', $this->schoolId)
                              ->whereRaw('LOWER(name) = ?', [strtolower($subjectName)])
                              ->first();
        if (!$subject) {
            $this->skippedCount++;
            $this->skippedRows[] = "সাবজেক্ট পাওয়া যায়নি: '{$subjectName}' (Name: {$row['name']})";
            return null;
        }

        // Generate teacher ID scoped to school
        $teacherId = Teacher::generateTeacherId($this->schoolId);

        // Parse date_of_birth
        $dob = null;
        if (!empty($row['date_of_birth'])) {
            try {
                $dob = \Carbon\Carbon::parse($row['date_of_birth'])->format('Y-m-d');
            } catch (\Exception $e) {
                $dob = null;
            }
        }

        // Parse joining_date
        $joiningDate = null;
        if (!empty($row['joining_date'])) {
            try {
                $joiningDate = \Carbon\Carbon::parse($row['joining_date'])->format('Y-m-d');
            } catch (\Exception $e) {
                $joiningDate = null;
            }
        }

        DB::transaction(function () use ($row, $subject, $teacherId, $dob, $joiningDate, $email) {
            $teacher = Teacher::create([
                'school_id'     => $this->schoolId,
                'teacher_id'    => $teacherId,
                'name'          => trim($row['name']),
                'subject_id'    => $subject->id,
                'email'         => $email ?: null,
                'phone'         => trim($row['phone'] ?? '') ?: null,
                'gender'        => strtolower(trim($row['gender'] ?? '')) ?: null,
                'date_of_birth' => $dob,
                'father_name'   => trim($row['father_name'] ?? '') ?: null,
                'mother_name'   => trim($row['mother_name'] ?? '') ?: null,
                'nid'           => trim($row['nid'] ?? '') ?: null,
                'blood_group'   => trim($row['blood_group'] ?? '') ?: null,
                'joining_date'  => $joiningDate,
                'qualification' => trim($row['qualification'] ?? '') ?: null,
                'address'       => trim($row['address'] ?? '') ?: null,
                'photo'         => null,
            ]);

            if ($email) {
                $user = User::create([
                    'school_id' => $this->schoolId,
                    'name'      => trim($row['name']),
                    'email'     => $email,
                    'password'  => Hash::make('12345678'),
                    'role'      => 'teacher',
                ]);
                $user->assignRole('teacher');
            }
        });

        $this->importedCount++;
        return null; // Model already created inside transaction
    }

    public function batchSize(): int  { return 100; }
    public function chunkSize(): int  { return 200; }
}
