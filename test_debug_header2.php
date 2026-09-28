<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\School;
use App\Models\Exam;
use App\Models\Student;
use App\Models\ExamRoutine;
use App\Models\AssignClass;

$school = School::whereNotNull('logo')->first() ?? School::first();
$exam = Exam::where('school_id', $school->id)->first() ?? Exam::first();
$student = Student::where('school_id', $school->id)->first() ?? Student::first();

$students = collect([$student]);
$instructionLines = $exam->admitCardInstructions();
$examRoutines = ExamRoutine::where('school_id', $school->id)->get()->keyBy('subject_id');
$assignClasses = AssignClass::where('school_id', $school->id)->get()->keyBy('subject_id');

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
    'margin_top'       => 6,
    'margin_bottom'    => 6,
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
]);

$html = view('school.exam.bulk_admit_card', compact(
    'students', 'exam', 'school', 'examRoutines', 'assignClasses', 'instructionLines'
))->render();

// Output what HTML is being passed to mPDF around the header
preg_match('/<table class="header-tbl".*?<\/table>/s', $html, $mH);
echo "=== HEADER HTML ===\n" . ($mH[0] ?? 'none') . "\n";

$mpdf->WriteHTML($html);
$pdf = $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);
file_put_contents('storage/debug_admit.pdf', $pdf);
echo "Saved to storage/debug_admit.pdf (" . strlen($pdf) . " bytes)\n";
