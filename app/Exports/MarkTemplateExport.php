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
        $students = Student::where('school_id', $this->schoolId)
            ->where('class_id', $this->classId)
            ->orderBy('roll')
            ->get(['id', 'roll', 'student_id', 'name']);

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
