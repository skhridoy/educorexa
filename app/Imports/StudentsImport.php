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
    public array $importErrors = [];
    public int $successCount   = 0;
    public int $skipCount      = 0;

    public function collection(Collection $rows)
    {
        $schoolId = Auth::user()->school_id;

        // ───── Active Academic Year ─────
        $academicYear = AcademicYear::where('school_id', $schoolId)
                                    ->where('is_active', 1)
                                    ->first();

        if (!$academicYear) {
            throw new Exception('কোনো সক্রিয় শিক্ষাবর্ষ পাওয়া যায়নি। অনুগ্রহ করে আগে একটি শিক্ষাবর্ষ সক্রিয় করুন।');
        }

        $yearPart   = substr($academicYear->name, -2);
        $prefix     = 'STD-' . $yearPart;

        // ───── Last serial for student_id generation ─────
        $lastSerial = Student::where('school_id', $schoolId)
            ->where('student_id', 'like', $prefix . '%')
            ->selectRaw("MAX(CAST(SUBSTRING(student_id, -4) AS UNSIGNED)) as max_serial")
            ->value('max_serial');

        $currentNextNumber = $lastSerial ? $lastSerial + 1 : 1001;

        // ───── Track used rolls per class ─────
        $usedRolls = [];

        foreach ($rows as $rowIndex => $row) {
            $rowNumber = $rowIndex + 2; // heading row = 1, data starts at 2

            // ── 1. Validate student name ──
            $name = trim($row['name'] ?? '');
            if (empty($name)) {
                $this->importErrors[] = "Row {$rowNumber}: 'name' ফাঁকা রাখা যাবে না।";
                $this->skipCount++;
                continue;
            }

            // ── 2. Resolve class by code ──
            $rawCode = trim($row['class_code'] ?? '');
            if (empty($rawCode)) {
                $this->importErrors[] = "Row {$rowNumber} ({$name}): 'class_code' কলামটি পূরণ করতে হবে।";
                $this->skipCount++;
                continue;
            }

            $excelCode = str_pad($rawCode, 2, '0', STR_PAD_LEFT);

            $class = Classes::where('school_id', $schoolId)
                            ->where('code', $excelCode)
                            ->first();

            if (!$class) {
                $this->importErrors[] = "Row {$rowNumber} ({$name}): class_code '{$rawCode}' এর কোনো ক্লাস পাওয়া যায়নি। অনুগ্রহ করে ক্লাস কোডটি যাচাই করুন।";
                $this->skipCount++;
                continue;
            }

            $classId    = $class->id;
            $categoryId = $class->school_category_id;

            // ── 3. Sub-category ──
            $subCategoryId = isset($row['sub_category_id']) && !empty($row['sub_category_id'])
                             ? (int)$row['sub_category_id']
                             : null;

            // ── 4. Resolve section by NAME (not raw value) ──
            $sectionId = null;
            $rawSection = trim($row['section'] ?? '');

            if (!empty($rawSection)) {
                // Try to find by section name (sections table has no class_id)
                $sectionObj = Section::where('school_id', $schoolId)
                                     ->whereRaw('LOWER(name) = ?', [strtolower($rawSection)])
                                     ->first();

                if ($sectionObj) {
                    $sectionId = $sectionObj->id;
                } else {
                    // If it's a numeric value, treat it as ID
                    if (is_numeric($rawSection)) {
                        $sectionObj = Section::where('school_id', $schoolId)
                                             ->where('id', (int)$rawSection)
                                             ->first();
                        if ($sectionObj) {
                            $sectionId = $sectionObj->id;
                        } else {
                            $this->importErrors[] = "Row {$rowNumber} ({$name}): section '{$rawSection}' — এই ID-তে কোনো section পাওয়া যায়নি। প্রথম section ব্যবহার করা হয়েছে।";
                        }
                    } else {
                        $this->importErrors[] = "Row {$rowNumber} ({$name}): section '{$rawSection}' — এই নামের কোনো section নেই। প্রথম section ব্যবহার করা হয়েছে।";
                    }
                }
            }

            // Fallback: default to first section for this school
            if (!$sectionId) {
                $defaultSection = Section::where('school_id', $schoolId)
                                         ->first();
                $sectionId = $defaultSection?->id;
            }

            // ── 5. Roll assignment ──
            if (!isset($usedRolls[$classId])) {
                $usedRolls[$classId] = Student::where('school_id', $schoolId)
                    ->where('class_id', $classId)
                    ->where('academic_year_id', $academicYear->id)
                    ->pluck('roll')
                    ->toArray();
            }

            $finalRoll = null;
            if (isset($row['roll']) && $row['roll'] !== '' && $row['roll'] !== null) {
                $rollVal = trim($row['roll']);
                if (!is_numeric($rollVal)) {
                    $this->importErrors[] = "Row {$rowNumber} ({$name}): 'roll' এর মান '{$rollVal}' একটি সংখ্যা হতে হবে। স্বয়ংক্রিয় roll নম্বর দেওয়া হয়েছে।";
                    // auto-assign
                    $suggestedRoll = 1;
                    while (in_array($suggestedRoll, $usedRolls[$classId])) {
                        $suggestedRoll++;
                    }
                    $finalRoll = $suggestedRoll;
                } else {
                    $finalRoll = (int)$rollVal;
                }
            } else {
                $suggestedRoll = 1;
                while (in_array($suggestedRoll, $usedRolls[$classId])) {
                    $suggestedRoll++;
                }
                $finalRoll = $suggestedRoll;
            }

            $usedRolls[$classId][] = $finalRoll;

            // ── 6. Date of birth ──
            $dob = null;
            if (!empty($row['date_of_birth'])) {
                try {
                    $rawDob = $row['date_of_birth'];
                    if (is_numeric($rawDob)) {
                        $dob = Date::excelToDateTimeObject($rawDob)->format('Y-m-d');
                    } else {
                        $dob = \Carbon\Carbon::parse($rawDob)->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    $this->importErrors[] = "Row {$rowNumber} ({$name}): date_of_birth '{$row['date_of_birth']}' ফরম্যাট বোঝা যাচ্ছে না। খালি রাখা হয়েছে।";
                    $dob = null;
                }
            }

            // ── 7. Validate gender ──
            $gender = trim($row['gender'] ?? '');
            $allowedGenders = ['male', 'female', 'other', 'Male', 'Female', 'Other'];
            if (!empty($gender) && !in_array($gender, $allowedGenders)) {
                $this->importErrors[] = "Row {$rowNumber} ({$name}): gender '{$gender}' অবৈধ। Male / Female / Other ব্যবহার করুন। খালি রাখা হয়েছে।";
                $gender = null;
            }

            // ── 8. Student ID ──
            $studentId = $prefix . str_pad($currentNextNumber, 4, '0', STR_PAD_LEFT);
            $currentNextNumber++;

            // ── 9. Save with transaction ──
            try {
                DB::transaction(function () use (
                    $row, $schoolId, $academicYear, $class, $categoryId,
                    $subCategoryId, $sectionId, $studentId, $finalRoll,
                    $name, $dob, $gender
                ) {
                    $user = User::updateOrCreate(
                        ['email' => $studentId . '@gmail.com'],
                        [
                            'school_id' => $schoolId,
                            'name'      => $name,
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
                        'school_category_id'     => $categoryId,
                        'school_sub_category_id' => $subCategoryId,
                        'class_id'               => $class->id,
                        'section_id'             => $sectionId,
                        'student_id'             => $studentId,
                        'roll'                   => $finalRoll,
                        'name'                   => $name,
                        'fathers_name'           => $row['fathers_name'] ?? null,
                        'mothers_name'           => $row['mothers_name'] ?? null,
                        'contact_number'         => $row['contact_number'] ?? null,
                        'date_of_birth'          => $dob,
                        'gender'                 => $gender,
                        'blood_group'            => $row['blood_group'] ?? null,
                        'religion'               => $row['religion'] ?? null,
                        'address'                => $row['address'] ?? null,
                        'password'               => Hash::make($row['password'] ?? '12345678'),
                        'status'                 => 'active',
                        'created_by'             => Auth::id(),
                    ]);
                });

                $this->successCount++;

            } catch (\Exception $e) {
                $this->importErrors[] = "Row {$rowNumber} ({$name}): ডেটা সেভ করতে সমস্যা হয়েছে — " . $this->friendlyDbError($e->getMessage());
                $this->skipCount++;
            }
        }
    }

    /**
     * Convert raw DB errors into friendly Bengali/English messages.
     */
    private function friendlyDbError(string $message): string
    {
        if (str_contains($message, 'Duplicate entry') && str_contains($message, 'students_student_id_unique')) {
            return 'এই Student ID আগেই ব্যবহার করা হয়েছে।';
        }
        if (str_contains($message, 'Duplicate entry')) {
            return 'এই তথ্য ইতিমধ্যে ডেটাবেজে রয়েছে (Duplicate Entry)।';
        }
        if (str_contains($message, 'section_id') && str_contains($message, 'Incorrect integer')) {
            return 'section_id অবশ্যই একটি সংখ্যা হতে হবে (কলামে section-এর নাম দিন, যেমন A বা Bangla)।';
        }
        if (str_contains($message, 'class_id') && str_contains($message, 'Incorrect integer')) {
            return 'class_id অবশ্যই একটি সংখ্যা হতে হবে।';
        }
        if (str_contains($message, 'Cannot add or update a child row')) {
            return 'Section বা Class ID ডেটাবেজে পাওয়া যায়নি — অনুগ্রহ করে ক্লাস কোড ও section নাম যাচাই করুন।';
        }
        if (str_contains($message, 'date_of_birth') || str_contains($message, 'Invalid datetime')) {
            return 'date_of_birth এর ফরম্যাট সঠিক নয়। YYYY-MM-DD ফরম্যাট ব্যবহার করুন।';
        }
        // fallback short message (no raw SQL)
        return 'অপ্রত্যাশিত সমস্যা হয়েছে। টেমপ্লেটের নির্দেশনা অনুসরণ করুন।';
    }
}
