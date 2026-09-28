<?php
require __DIR__ . '/vendor/autoload.php';
use Mpdf\Mpdf;

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

$mpdf = new Mpdf([
    'mode'             => 'utf-8',
    'format'           => 'A4-P',
    'fontDir'          => array_merge($fontDirs, [__DIR__ . '/public/fonts']),
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

$html = '
<style>
body { font-family: dejavusans, sans-serif; font-size: 14px; }
.bold { font-weight: bold; }
</style>
<body>
<div class="bold">DEMO INTERNATIONAL SCHOOL COLLEGE</div>
<div class="bold">Code: SCH0001</div>
<div class="bold">First Term Exam &mdash; 2026</div>
<div class="bold">অর্ধবার্ষিক মূল্যায়ন পরীক্ষা &mdash; ২০২৬</div>
<div class="bold">ADMIT CARD (প্রবেশপত্র)</div>
<div class="bold">First Term Exam Routine</div>
<div class="bold">অর্ধবার্ষিক মূল্যায়ন পরীক্ষা Routine</div>
</body>';

$mpdf->WriteHTML($html);
$pdf = $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);
file_put_contents('storage/test_mixed.pdf', $pdf);

preg_match_all('/\/BaseFont\s*\/([^\s\/]+)/', $pdf, $matches);
echo "Embedded fonts: " . implode(', ', array_unique($matches[1])) . "\n";
echo "PDF generated successfully (" . strlen($pdf) . " bytes)\n";
