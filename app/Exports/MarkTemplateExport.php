<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\AssignClass;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class MarkTemplateExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithStyles
{
    protected int    $schoolId;
    protected int    $classId;
    protected string $mode;     // 'single' | 'multi'
    protected ?int   $subjectId;
    protected string $subjectName;
    protected array  $subjectColumns = [];

    public function __construct(int $schoolId, int $classId, string $mode, ?int $subjectId = null, string $subjectName = 'marks')
    {
        $this->schoolId    = $schoolId;
        $this->classId     = $classId;
        $this->mode        = $mode;
        $this->subjectId   = $subjectId;
        $this->subjectName = $subjectName;

        if ($mode === 'multi') {
            // Load all assigned subjects for this class
            $assigned = AssignClass::where('class_id', $classId)
                ->with('subject')
                ->get();

            foreach ($assigned as $a) {
                if ($a->subject) {
                    $sName = $a->subject->name;
                    $this->subjectColumns[] = "{$sName} (CQ)";
                    $this->subjectColumns[] = "{$sName} (MCQ)";
                    $this->subjectColumns[] = "{$sName} (Practical)";
                }
            }
        }
    }

    public function collection()
    {
        $query = Student::where('school_id', $this->schoolId)
            ->where('class_id', $this->classId)
            ->orderBy('roll');

        if ($this->mode === 'single' && $this->subjectId) {
            $subject = \App\Models\Subject::find($this->subjectId);
            $assignClass = AssignClass::where('class_id', $this->classId)->where('subject_id', $this->subjectId)->first();
            $subCatId = $assignClass?->school_sub_category_id ?: $subject?->school_sub_category_id;

            if ($subCatId) {
                $query->where('school_sub_category_id', $subCatId);
            }

            $subName = mb_strtolower(trim($subject?->name ?? ''));
            $isIslam = str_contains($subName, 'islam') || str_contains($subName, 'ইসলাম') || str_contains($subName, 'deeniyat') || str_contains($subName, 'দ্বীনিয়াত') || str_contains($subName, 'কোরআন') || str_contains($subName, 'কুরআন') || str_contains($subName, 'হাদিস') || str_contains($subName, 'ফিকহ');
            $isHindu = str_contains($subName, 'hindu') || str_contains($subName, 'হিন্দু') || str_contains($subName, 'সনাতন');
            $isBuddha = str_contains($subName, 'buddh') || str_contains($subName, 'বৌদ্ধ') || str_contains($subName, 'বুদ্ধ');
            $isChristian = str_contains($subName, 'christ') || str_contains($subName, 'খ্রিস্ট') || str_contains($subName, 'খ্রিষ্ট');

            if ($isIslam) {
                $query->where(function($q) {
                    $q->where('religion', 'Islam')
                      ->orWhere('religion', 'islam')
                      ->orWhere('religion', 'LIKE', '%Islam%')
                      ->orWhere('religion', 'LIKE', '%ইসলাম%')
                      ->orWhere('religion', 'LIKE', '%Muslim%')
                      ->orWhere('religion', 'LIKE', '%মুসলিম%')
                      ->orWhereNull('religion')
                      ->orWhere('religion', '');
                });
            } elseif ($isHindu) {
                $query->where(function($q) {
                    $q->where('religion', 'Hinduism')
                      ->orWhere('religion', 'hinduism')
                      ->orWhere('religion', 'LIKE', '%Hindu%')
                      ->orWhere('religion', 'LIKE', '%হিন্দু%')
                      ->orWhere('religion', 'LIKE', '%সনাতন%');
                });
            } elseif ($isBuddha) {
                $query->where(function($q) {
                    $q->where('religion', 'Buddhism')
                      ->orWhere('religion', 'buddhism')
                      ->orWhere('religion', 'LIKE', '%Buddh%')
                      ->orWhere('religion', 'LIKE', '%বৌদ্ধ%')
                      ->orWhere('religion', 'LIKE', '%বুদ্ধ%');
                });
            } elseif ($isChristian) {
                $query->where(function($q) {
                    $q->where('religion', 'Christianity')
                      ->orWhere('religion', 'christianity')
                      ->orWhere('religion', 'LIKE', '%Christ%')
                      ->orWhere('religion', 'LIKE', '%খ্রিস্ট%')
                      ->orWhere('religion', 'LIKE', '%খ্রিষ্ট%');
                });
            }
        }

        $students = $query->get(['id', 'roll', 'student_id', 'name']);

        return $students->map(function ($s) {
            $row = [
                'roll'         => $s->roll,
                'student_name' => $s->name,
                'student_id'   => $s->student_id,
            ];

            if ($this->mode === 'single') {
                $row['CQ']        = '';
                $row['MCQ']       = '';
                $row['Practical'] = '';
            } else {
                foreach ($this->subjectColumns as $colName) {
                    $row[$colName] = '';
                }
            }

            return $row;
        });
    }

    public function headings(): array
    {
        $base = ['roll', 'student_name', 'student_id'];

        if ($this->mode === 'single') {
            return array_merge($base, ['CQ', 'MCQ', 'Practical']);
        }

        return array_merge($base, $this->subjectColumns);
    }

    public function title(): string
    {
        return 'Mark Import Template';
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Header row bold + colored
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5'],
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}
