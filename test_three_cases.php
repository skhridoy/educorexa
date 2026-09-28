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

// Test case 1: English Exam Name
$examEnglish = clone $exam;
$examEnglish->name = 'First Term Exam';

// Test case 2: Bengali Exam Name
$examBengali = clone $exam;
$examBengali->name = 'অর্ধবার্ষিক পরীক্ষা';

// Test case 3: Mixed Exam Name
$examMixed = clone $exam;
$examMixed->name = '1st Term Exam (১ম সাময়িক পরীক্ষা)';

echo "School Name: " . $school->name . "\n";

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
    'fontDir'          => array_merge($fontDirs, [public_path('fonts')]),
    'fontdata'         => $fontData + [
        'solaimanlipi' => [
            'R'  => 'SolaimanLipi.ttf',
            'B'  => 'SolaimanLipi.ttf',
            'I'  => 'SolaimanLipi.ttf',
            'BI' => 'SolaimanLipi.ttf',
            'useOTL' => 0xFF,
            'useKashida' => 75,
        ],
        'kalpurush' => [
            'R'  => 'kalpurush.ttf',
            'B'  => 'kalpurush.ttf',
            'I'  => 'kalpurush.ttf',
            'BI' => 'kalpurush.ttf',
            'useOTL' => 0xFF,
            'useKashida' => 75,
        ],
    ],
    'languageToFont'   => $customLangToFont,
    'autoScriptToLang' => true,
    'autoLangToFont'   => true,
]);

// Test clean header snippet without forced lang="bn"
$html = '
<style>
body { font-family: dejavusans, sans-serif; font-size: 10px; color: #0f172a; }
.school-name { font-size: 14px; font-weight: bold; text-transform: uppercase; color: #0f172a; }
.school-code-line { font-size: 8px; color: #475569; font-weight: 600; }
.exam-name-line { font-size: 10.5px; font-weight: bold; color: #1e3a8a; }
.admit-badge { display: inline-block; background: #e0e7ff; color: #1e3a8a; font-size: 9px; font-weight: bold; padding: 2px 7px; border-radius: 3px; }
.routine-heading { font-size: 9px; font-weight: bold; color: #0f172a; background: #f1f5f9; padding: 2px 4px; text-align: center; text-transform: uppercase; }
</style>
<body>
<div style="border: 1px solid #333; padding: 10px; margin-bottom: 10px;">
    <div class="school-name">' . htmlspecialchars($school->name) . '</div>
    <div class="school-code-line">Code: ' . ($school->app_code ?? 'SCH0001') . '</div>
    <div class="exam-name-line">' . htmlspecialchars($examEnglish->name) . ' &mdash; 2026</div>
    <div><span class="admit-badge">ADMIT CARD (প্রবেশপত্র)</span></div>
    <div class="routine-heading">' . htmlspecialchars($examEnglish->name) . ' ROUTINE</div>
</div>

<div style="border: 1px solid #333; padding: 10px; margin-bottom: 10px;">
    <div class="school-name">ডেমো ইন্টারন্যাশনাল স্কুল এন্ড কলেজ</div>
    <div class="school-code-line">কোড: SCH0001</div>
    <div class="exam-name-line">' . htmlspecialchars($examBengali->name) . ' &mdash; ২০২৬</div>
    <div><span class="admit-badge">ADMIT CARD (প্রবেশপত্র)</span></div>
    <div class="routine-heading">' . htmlspecialchars($examBengali->name) . ' ROUTINE</div>
</div>

<div style="border: 1px solid #333; padding: 10px;">
    <div class="school-name">' . htmlspecialchars($school->name) . '</div>
    <div class="exam-name-line">' . htmlspecialchars($examMixed->name) . ' &mdash; 2026</div>
    <div><span class="admit-badge">ADMIT CARD (প্রবেশপত্র)</span></div>
    <div class="routine-heading">' . htmlspecialchars($examMixed->name) . ' ROUTINE</div>
</div>
</body>';

$mpdf->WriteHTML($html);
$pdf = $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);
file_put_contents('storage/test_three_cases.pdf', $pdf);

echo "PDF created successfully! Size: " . strlen($pdf) . " bytes\n";
preg_match_all('/\/BaseFont\s*\/([^\s\/]+)/', $pdf, $matches);
echo "Embedded fonts: " . implode(', ', array_unique($matches[1])) . "\n";
