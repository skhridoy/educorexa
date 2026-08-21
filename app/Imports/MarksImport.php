<?php

namespace App\Imports;

use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use App\Models\AssignClass;
use App\Models\AcademicYear;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MarksImport implements ToCollection, WithHeadingRow
{
    public int   $successCount = 0;
    public int   $skipCount    = 0;
    public array $importErrors = [];

    protected int  $schoolId;
    protected int  $examId;
    protected int  $classId;
    protected ?int $subjectId;   // null = multi-subject mode
    protected string $mode;      // 'single' | 'multi'

    public function __construct(int $schoolId, int $examId, int $classId, ?int $subjectId, string $mode = 'single')
    {
        $this->schoolId  = $schoolId;
        $this->examId    = $examId;
        $this->classId   = $classId;
        $this->subjectId = $subjectId;
        $this->mode      = $mode;
    }

    public function collection(Collection $rows)
    {
        // ── Active Academic Year ──
        $academicYear = AcademicYear::where('school_id', $this->schoolId)
                                    ->where('is_active', 1)
                                    ->first();

        if (!$academicYear) {
            throw new \Exception('কোনো সক্রিয় শিক্ষাবর্ষ পাওয়া যায়নি।');
        }

        // ── Pre-load all students of the class (indexed by roll) ──
        $studentsByRoll = Student::where('school_id', $this->schoolId)
                                  ->where('class_id', $this->classId)
                                  ->get()
                                  ->keyBy('roll');

        // Also index by student_id for fallback
        $studentsByStudentId = Student::where('school_id', $this->schoolId)
                                       ->where('class_id', $this->classId)
                                       ->get()
                                       ->keyBy('student_id');

        // ── For multi-subject mode: load assigned subjects ──
        $assignedSubjects = [];
        if ($this->mode === 'multi') {
            $assignedSubjects = AssignClass::where('class_id', $this->classId)
                ->with('subject')
                ->get()
                ->pluck('subject')
                ->filter()
                ->values();
        }

        foreach ($rows as $rowIndex => $row) {
            $rowNumber = $rowIndex + 2;

            // ── Resolve student ──
            $rawRoll      = trim($row['roll'] ?? '');
            $rawStudentId = trim($row['student_id'] ?? '');

            $student = null;

            if ($rawRoll !== '' && is_numeric($rawRoll)) {
                $student = $studentsByRoll->get((int)$rawRoll);
            }

            // Fallback: student_id column
            if (!$student && $rawStudentId !== '') {
                $student = $studentsByStudentId->get($rawStudentId);
            }

            if (!$student) {
                $label = $rawRoll !== '' ? "roll '{$rawRoll}'" : "student_id '{$rawStudentId}'";
                $this->importErrors[] = "Row {$rowNumber}: {$label} — এই ক্লাসে কোনো student পাওয়া যায়নি। Row skip করা হয়েছে।";
                $this->skipCount++;
                continue;
            }

            if ($this->mode === 'single') {
                // ── Single-subject mode ──
                $rawCq   = $row['cq'] ?? null;
                $rawMcq  = $row['mcq'] ?? null;
                $rawPrac = $row['practical'] ?? $row['prac'] ?? null;
                $rawMark = $row['marks'] ?? $row['mark'] ?? $row['total'] ?? null;

                $hasCq   = $rawCq !== null && trim((string)$rawCq) !== '';
                $hasMcq  = $rawMcq !== null && trim((string)$rawMcq) !== '';
                $hasPrac = $rawPrac !== null && trim((string)$rawPrac) !== '';
                $hasMark = $rawMark !== null && trim((string)$rawMark) !== '';

                if (!$hasCq && !$hasMcq && !$hasPrac && !$hasMark) {
                    $this->importErrors[] = "Row {$rowNumber} (Roll {$student->roll} — {$student->name}): কোনো নম্বর দেওয়া হয়নি। Skip করা হয়েছে।";
                    $this->skipCount++;
                    continue;
                }

                $cq        = $hasCq && is_numeric($rawCq) ? (int)$rawCq : null;
                $mcq       = $hasMcq && is_numeric($rawMcq) ? (int)$rawMcq : null;
                $practical = $hasPrac && is_numeric($rawPrac) ? (int)$rawPrac : null;

                if ($cq !== null || $mcq !== null || $practical !== null) {
                    $finalMarks = (int)(($cq ?? 0) + ($mcq ?? 0) + ($practical ?? 0));
                } else {
                    $finalMarks = $hasMark && is_numeric($rawMark) ? (int)$rawMark : 0;
                }

                try {
                    Mark::updateOrCreate(
                        [
                            'school_id'        => $this->schoolId,
                            'academic_year_id' => $academicYear->id,
                            'student_id'       => $student->id,
                            'class_id'         => $this->classId,
                            'exam_id'          => $this->examId,
                            'subject_id'       => $this->subjectId,
                        ],
                        [
                            'cq'        => $cq,
                            'mcq'       => $mcq,
                            'practical' => $practical,
                            'marks'     => $finalMarks,
                            'status'    => 'present'
                        ]
                    );
                    $this->successCount++;
                } catch (\Exception $e) {
                    $this->importErrors[] = "Row {$rowNumber} (Roll {$student->roll}): সেভ করতে সমস্যা — " . $this->friendlyError($e->getMessage());
                    $this->skipCount++;
                }

            } else {
                // ── Multi-subject mode (supports both direct subject marks and CQ/MCQ/Practical breakdown) ──
                $rowHadSuccess = false;
                $subjectData   = []; // [ subjectId => [ 'cq' => ..., 'mcq' => ..., 'practical' => ..., 'marks' => ... ] ]

                // Each column that is not roll/student_name/student_id is analyzed
                foreach ($row as $colKey => $colVal) {
                    if (in_array($colKey, ['roll', 'student_name', 'student_id', ''])) {
                        continue;
                    }

                    if ($colVal === null || trim((string)$colVal) === '') {
                        continue; // blank mark = skip silently
                    }

                    $fieldType   = 'marks';
                    $cleanColKey = $colKey;

                    if (preg_match('/^(.*)_(cq|mcq|practical|prac|ca|total|marks|total_marks)$/i', $colKey, $matches)) {
                        $cleanColKey = $matches[1];
                        $suffix      = strtolower($matches[2]);
                        if ($suffix === 'cq') {
                            $fieldType = 'cq';
                        } elseif ($suffix === 'mcq') {
                            $fieldType = 'mcq';
                        } elseif (in_array($suffix, ['practical', 'prac', 'ca'])) {
                            $fieldType = 'practical';
                        } else {
                            $fieldType = 'marks';
                        }
                    }

                    // match column name accurately to subject
                    $resolvedSubjectId = $this->resolveSubjectId($cleanColKey, $assignedSubjects);

                    if (!$resolvedSubjectId) {
                        $this->importErrors[] = "Row {$rowNumber}: column '{$colKey}' — এই নামে কোনো subject পাওয়া যায়নি এই ক্লাসে। Column skip।";
                        continue;
                    }

                    if (!is_numeric($colVal)) {
                        $this->importErrors[] = "Row {$rowNumber} (Roll {$student->roll}, '{$colKey}'): নম্বর '{$colVal}' একটি সংখ্যা হতে হবে।";
                        continue;
                    }

                    $subjectData[$resolvedSubjectId][$fieldType] = (int)$colVal;
                }

                foreach ($subjectData as $resolvedSubjectId => $subMarks) {
                    $cq        = isset($subMarks['cq']) ? (int)$subMarks['cq'] : null;
                    $mcq       = isset($subMarks['mcq']) ? (int)$subMarks['mcq'] : null;
                    $practical = isset($subMarks['practical']) ? (int)$subMarks['practical'] : null;
                    $rawMarks  = isset($subMarks['marks']) ? (int)$subMarks['marks'] : null;

                    if ($cq !== null || $mcq !== null || $practical !== null) {
                        $finalMarks = (int)(($cq ?? 0) + ($mcq ?? 0) + ($practical ?? 0));
                    } else {
                        $finalMarks = $rawMarks ?? 0;
                    }

                    try {
                        Mark::updateOrCreate(
                            [
                                'school_id'        => $this->schoolId,
                                'academic_year_id' => $academicYear->id,
                                'student_id'       => $student->id,
                                'class_id'         => $this->classId,
                                'exam_id'          => $this->examId,
                                'subject_id'       => $resolvedSubjectId,
                            ],
                            [
                                'cq'        => $cq,
                                'mcq'       => $mcq,
                                'practical' => $practical,
                                'marks'     => $finalMarks,
                                'status'    => 'present'
                            ]
                        );
                        $rowHadSuccess = true;
                    } catch (\Exception $e) {
                        $this->importErrors[] = "Row {$rowNumber} (Roll {$student->roll}): সেভ করতে সমস্যা — " . $this->friendlyError($e->getMessage());
                    }
                }

                if ($rowHadSuccess) {
                    $this->successCount++;
                } else {
                    $this->skipCount++;
                }
            }
        }
    }

    /**
     * Accurately resolve Excel column key to Subject ID
     */
    private function resolveSubjectId(string $colKey, $assignedSubjects): ?int
    {
        $colKeyClean = mb_strtolower(trim($colKey));
        $colKeyAlpha = preg_replace('/[^a-z0-9\x{0980}-\x{09FF}]/u', '', $colKeyClean);

        // 1. Exact Name / Slug / Code matches
        foreach ($assignedSubjects as $sub) {
            $subName = mb_strtolower(trim($sub->name));
            $subSlug = \Illuminate\Support\Str::slug($sub->name, '_');
            $subAlpha = preg_replace('/[^a-z0-9\x{0980}-\x{09FF}]/u', '', $subName);

            if ($colKeyClean === $subName || $colKeyClean === $subSlug || $colKeyAlpha === $subAlpha || (string)$sub->code === $colKeyClean) {
                return $sub->id;
            }
        }

        // 2. Specialized Check for Bangla 2nd / English 2nd vs 1st
        $isSecond = (
            str_contains($colKeyClean, '2') ||
            str_contains($colKeyClean, '2nd') ||
            str_contains($colKeyClean, 'second') ||
            str_contains($colKeyClean, '২') ||
            str_contains($colKeyClean, '২য়') ||
            str_contains($colKeyClean, 'দ্বিতীয়')
        );

        if (str_contains($colKeyClean, 'bangla') || str_contains($colKeyClean, 'বাংলা')) {
            foreach ($assignedSubjects as $sub) {
                $name = mb_strtolower($sub->name);
                $subIs2nd = (
                    str_contains($name, '2') || str_contains($name, '2nd') || str_contains($name, 'second') ||
                    str_contains($name, '২') || str_contains($name, '২য়') || str_contains($name, 'দ্বিতীয়')
                );
                if ($isSecond && $subIs2nd && (str_contains($name, 'bangla') || str_contains($name, 'বাংলা'))) {
                    return $sub->id;
                }
                if (!$isSecond && !$subIs2nd && (str_contains($name, 'bangla') || str_contains($name, 'বাংলা'))) {
                    return $sub->id;
                }
            }
        }

        if (str_contains($colKeyClean, 'english') || str_contains($colKeyClean, 'ইংরেজি')) {
            foreach ($assignedSubjects as $sub) {
                $name = mb_strtolower($sub->name);
                $subIs2nd = (
                    str_contains($name, '2') || str_contains($name, '2nd') || str_contains($name, 'second') ||
                    str_contains($name, '২') || str_contains($name, '২য়') || str_contains($name, 'দ্বিতীয়')
                );
                if ($isSecond && $subIs2nd && (str_contains($name, 'english') || str_contains($name, 'ইংরেজি'))) {
                    return $sub->id;
                }
                if (!$isSecond && !$subIs2nd && (str_contains($name, 'english') || str_contains($name, 'ইংরেজি'))) {
                    return $sub->id;
                }
            }
        }

        // 3. General substring match
        foreach ($assignedSubjects as $sub) {
            $subName = mb_strtolower(trim($sub->name));
            $subAlpha = preg_replace('/[^a-z0-9\x{0980}-\x{09FF}]/u', '', $subName);
            if (str_contains($colKeyAlpha, $subAlpha) || str_contains($subAlpha, $colKeyAlpha)) {
                return $sub->id;
            }
        }

        return null;
    }

    private function friendlyError(string $msg): string
    {
        if (str_contains($msg, 'Duplicate entry')) {
            return 'এই mark ইতিমধ্যে আছে (Duplicate)।';
        }
        return 'অপ্রত্যাশিত সমস্যা।';
    }
}
