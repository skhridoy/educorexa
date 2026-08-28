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

        $yearPart = substr($academicYear->name, -2);
        $prefix   = 'STD-' . $yearPart;

        // ───── Global max serial for student_id generation ─────
        $lastSerial = Student::where('student_id', 'like', $prefix . '%')
            ->selectRaw("MAX(CAST(SUBSTRING(student_id, -4) AS UNSIGNED)) as max_serial")
            ->value('max_serial');

        $currentNextNumber = $lastSerial ? $lastSerial + 1 : 1001;

        // ───── Track used rolls per class ─────
        $usedRolls = [];

        foreach ($rows as $rowIndex => $row) {
            $rowNumber = $rowIndex + 2; // heading row = 1, data starts at 2

            // ── 1. Validate student name ──
            $name = trim($row['name'] ?? $row['student_name'] ?? '');
            if (empty($name)) {
                $this->importErrors[] = "Row {$rowNumber}: 'name' ফাঁকা রাখা যাবে না।";
                $this->skipCount++;
                continue;
            }

            // ── 2. Resolve class (by code, id, or name) ──
            $rawCode = trim($row['class_code'] ?? $row['class'] ?? $row['class_name'] ?? $row['class_id'] ?? '');
            if (empty($rawCode)) {
                $this->importErrors[] = "Row {$rowNumber} ({$name}): 'class_code' কলামটি পূরণ করতে হবে।";
                $this->skipCount++;
                continue;
            }

            $excelCode = is_numeric($rawCode) ? str_pad($rawCode, 2, '0', STR_PAD_LEFT) : $rawCode;

            $class = Classes::where('school_id', $schoolId)
                ->where(function($q) use ($rawCode, $excelCode) {
                    $q->where('code', $rawCode)
                      ->orWhere('code', $excelCode)
                      ->orWhere('code', ltrim($rawCode, '0'))
                      ->orWhereRaw('LOWER(name) = ?', [strtolower($rawCode)])
                      ->orWhere('name', 'LIKE', '%' . $rawCode . '%');
                    if (is_numeric($rawCode)) {
                        $q->orWhere('id', (int)$rawCode);
                    }
                })
                ->first();

            if (!$class) {
                $this->importErrors[] = "Row {$rowNumber} ({$name}): class '{$rawCode}' এর কোনো শ্রেণি পাওয়া যায়নি। অনুগ্রহ করে শ্রেণি/কোড যাচাই করুন।";
                $this->skipCount++;
                continue;
            }

            $classId    = $class->id;
            $categoryId = $class->school_category_id;

            // ── 3. Sub-category (Group) resolution ──
            $subCategoryId = null;
            $rawSubCat = trim($row['sub_category_id'] ?? $row['sub_category'] ?? $row['subcategory'] ?? $row['group'] ?? $row['group_name'] ?? '');

            if (!empty($rawSubCat)) {
                if (is_numeric($rawSubCat)) {
                    $subCatObj = \App\Models\SchoolSubCategory::where('school_id', $schoolId)->where('id', (int)$rawSubCat)->first();
                    $subCategoryId = $subCatObj?->id;
                } else {
                    $subCatObj = \App\Models\SchoolSubCategory::where('school_id', $schoolId)
                        ->where(function($q) use ($rawSubCat) {
                            $q->whereRaw('LOWER(name) = ?', [strtolower($rawSubCat)])
                              ->orWhere('name', 'LIKE', '%' . $rawSubCat . '%');
                        })->first();
                    $subCategoryId = $subCatObj?->id;
                }
            }

            // ── 4. Resolve section by NAME or ID ──
            $sectionId = null;
            $rawSection = trim($row['section'] ?? $row['section_name'] ?? $row['section_id'] ?? '');

            if (!empty($rawSection)) {
                $sectionObj = Section::where('school_id', $schoolId)
                    ->where(function($q) use ($rawSection) {
                        $q->whereRaw('LOWER(name) = ?', [strtolower($rawSection)])
                          ->orWhere('name', 'LIKE', '%' . $rawSection . '%');
                        if (is_numeric($rawSection)) {
                            $q->orWhere('id', (int)$rawSection);
                        }
                    })
                    ->first();

                if ($sectionObj) {
                    $sectionId = $sectionObj->id;
                }
            }

            // Fallback: default to first section for this school
            if (!$sectionId) {
                $defaultSection = Section::where('school_id', $schoolId)->first();
                $sectionId = $defaultSection?->id;
            }

            // ── 5. Roll assignment (Group-specific) ──
            $groupKey = $classId . '_' . ($subCategoryId ?? 'common');

            if (!isset($usedRolls[$groupKey])) {
                $rollQuery = Student::where('school_id', $schoolId)
                    ->where('class_id', $classId)
                    ->where('academic_year_id', $academicYear->id);

                if ($subCategoryId) {
                    $rollQuery->where('school_sub_category_id', $subCategoryId);
                } else {
                    $rollQuery->whereNull('school_sub_category_id');
                }

                $usedRolls[$groupKey] = $rollQuery->pluck('roll')->toArray();
            }

            $finalRoll = null;
            $rawRoll = $row['roll'] ?? $row['roll_no'] ?? $row['roll_number'] ?? null;
            if ($rawRoll !== '' && $rawRoll !== null) {
                $rollVal = trim($rawRoll);
                if (is_numeric($rollVal)) {
                    $finalRoll = (int)$rollVal;
                } else {
                    $suggestedRoll = 1;
                    while (in_array($suggestedRoll, $usedRolls[$groupKey])) {
                        $suggestedRoll++;
                    }
                    $finalRoll = $suggestedRoll;
                }
            } else {
                $suggestedRoll = 1;
                while (in_array($suggestedRoll, $usedRolls[$groupKey])) {
                    $suggestedRoll++;
                }
                $finalRoll = $suggestedRoll;
            }

            $usedRolls[$groupKey][] = $finalRoll;

            // ── 6. Date of birth ──
            $dob = null;
            $rawDob = $row['date_of_birth'] ?? $row['dob'] ?? $row['birth_date'] ?? null;
            if (!empty($rawDob)) {
                try {
                    if (is_numeric($rawDob)) {
                        $dob = Date::excelToDateTimeObject($rawDob)->format('Y-m-d');
                    } else {
                        $dob = \Carbon\Carbon::parse(str_replace('/', '-', $rawDob))->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    $dob = null;
                }
            }

            // ── 7. Normalize gender ──
            $rawGender = trim($row['gender'] ?? '');
            $gender = null;
            if (!empty($rawGender)) {
                $gLower = strtolower($rawGender);
                if (in_array($gLower, ['male', 'm', 'পুরুষ', 'ছেলে', 'boy'])) {
                    $gender = 'Male';
                } elseif (in_array($gLower, ['female', 'f', 'মহিলা', 'মেয়ে', 'মেয়ে', 'girl'])) {
                    $gender = 'Female';
                } else {
                    $gender = 'Other';
                }
            }

            // ── 8. Normalize religion ──
            $rawRel = trim($row['religion'] ?? '');
            $religion = 'Islam';
            if (!empty($rawRel)) {
                $relLower = strtolower($rawRel);
                if (str_contains($relLower, 'islam') || str_contains($relLower, 'ইসলাম') || str_contains($relLower, 'muslim') || str_contains($relLower, 'মুসলিম')) {
                    $religion = 'Islam';
                } elseif (str_contains($relLower, 'hindu') || str_contains($relLower, 'হিন্দু') || str_contains($relLower, 'সনাতন')) {
                    $religion = 'Hinduism';
                } elseif (str_contains($relLower, 'buddh') || str_contains($relLower, 'বৌদ্ধ') || str_contains($relLower, 'বুদ্ধ')) {
                    $religion = 'Buddhism';
                } elseif (str_contains($relLower, 'christ') || str_contains($relLower, 'খ্রিস্ট') || str_contains($relLower, 'খ্রিষ্ট')) {
                    $religion = 'Christianity';
                } else {
                    $religion = ucfirst($rawRel);
                }
            }

            // ── 9. Generate guaranteed unique Student ID ──
            do {
                $studentId = $prefix . str_pad($currentNextNumber, 4, '0', STR_PAD_LEFT);
                $currentNextNumber++;
            } while (Student::where('student_id', $studentId)->exists() || User::where('email', $studentId . '@gmail.com')->exists());

            // ── 10. Save with transaction ──
            try {
                DB::transaction(function () use (
                    $row, $schoolId, $academicYear, $class, $categoryId,
                    $subCategoryId, $sectionId, $studentId, $finalRoll,
                    $name, $dob, $gender, $religion
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
                        'fathers_name'           => $row['fathers_name'] ?? $row['father_name'] ?? null,
                        'mothers_name'           => $row['mothers_name'] ?? $row['mother_name'] ?? null,
                        'contact_number'         => $row['contact_number'] ?? $row['phone'] ?? null,
                        'date_of_birth'          => $dob,
                        'gender'                 => $gender,
                        'blood_group'            => $row['blood_group'] ?? null,
                        'religion'               => $religion,
                        'address'                => $row['address'] ?? null,
                        'password'               => Hash::make($row['password'] ?? '12345678'),
                        'status'                 => 'active',
                        'admission_date'         => now()->format('Y-m-d'),
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
            return 'section কলামে সঠিক সেকশন নাম (যেমন A বা B) দিন।';
        }
        if (str_contains($message, 'class_id') && str_contains($message, 'Incorrect integer')) {
            return 'class_code কলামে সঠিক ক্লাস কোড বা নাম দিন।';
        }
        if (str_contains($message, 'Cannot add or update a child row')) {
            return 'শ্রেণি, সেকশন বা গ্রুপের তথ্য ডেটাবেজে পাওয়া যায়নি।';
        }
        if (str_contains($message, 'date_of_birth') || str_contains($message, 'Invalid datetime')) {
            return 'date_of_birth এর ফরম্যাট সঠিক নয়। YYYY-MM-DD ফরম্যাট ব্যবহার করুন।';
        }
        return 'অপ্রত্যাশিত সমস্যা: ' . (str_contains($message, '(SQL:') ? trim(substr($message, 0, strpos($message, '(SQL:'))) : $message);
    }
}
