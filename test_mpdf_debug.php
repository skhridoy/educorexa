<?php
require 'vendor/autoload.php';

$bootstrap = require __DIR__ . '/bootstrap/app.php';
$kernel = $bootstrap->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$school = \App\Models\School::first();
$exam = \App\Models\Exam::first();
$student = \App\Models\Student::first();
$examRoutines = \App\Models\ExamRoutine::where('exam_id', $exam?->id)->get();
$assignClasses = collect();
$instructionLines = $exam?->admit_card_instruction_lines ?? [];
$students = collect([$student, $student]);

$html = view('school.exam.bulk_admit_card', compact(
    'students', 'exam', 'school', 'examRoutines', 'assignClasses', 'instructionLines'
))->render();

$defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];
$defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$customLangToFont = new class extends \Mpdf\Language\LanguageToFont {
    public function getLanguageOptions($llcc, $adobeCJK) {
        $res = parent::getLanguageOptions($llcc, $adobeCJK);
        if (in_array(strtolower($llcc), ['bn', 'ben', 'bengali', 'beng'])) {
            return [false, 'solaimanlipi'];
        }
        return $res;
    }
};

$mpdf = new \Mpdf\Mpdf([
    'mode'             => 'utf-8',
    'format'           => 'A4-P',
    'margin_left'      => 7,
    'margin_right'     => 7,
    'margin_top'       => 7,
    'margin_bottom'    => 7,
    'margin_header'    => 0,
    'margin_footer'    => 0,
    'fontDir'          => array_merge($fontDirs, [
        public_path('fonts'),
    ]),
    'fontdata'         => $fontData + [
        'solaimanlipi' => [
            'R'          => 'SolaimanLipi.ttf',
            'B'          => 'SolaimanLipi.ttf',
            'I'          => 'SolaimanLipi.ttf',
            'BI'         => 'SolaimanLipi.ttf',
            'useOTL'     => 0xFF,
            'useKashida' => 75,
        ],
        'kalpurush' => [
            'R'          => 'kalpurush.ttf',
            'B'          => 'kalpurush.ttf',
            'I'          => 'kalpurush.ttf',
            'BI'         => 'kalpurush.ttf',
            'useOTL'     => 0xFF,
            'useKashida' => 75,
        ],
    ],
    'languageToFont'   => $customLangToFont,
    'autoScriptToLang' => true,
    'autoLangToFont'   => true,
    'tempDir'          => storage_path('app/mpdf'),
]);

$mpdf->WriteHTML($html);
$pdf = $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);
file_put_contents('test_admit.pdf', $pdf);
echo "PDF created successfully! Size: " . strlen($pdf) . " bytes\n";
