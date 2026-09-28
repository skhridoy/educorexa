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
    ],
    'languageToFont'   => $customLangToFont,
    'autoScriptToLang' => true,
    'autoLangToFont'   => true,
]);

$html = '
<style>
body { font-family: dejavusans, sans-serif; font-size: 14px; }
.test1 { font-family: solaimanlipi; font-weight: bold; }
.test2 { font-family: dejavusans; font-weight: bold; }
.bn { font-family: solaimanlipi; }
</style>
<body>
<div class="test1">DEMO INTERNATIONAL SCHOOL COLLEGE (SolaimanLipi Bold)</div>
<div class="test2">DEMO INTERNATIONAL SCHOOL COLLEGE (DejaVuSans Bold)</div>
<div class="test1"><span lang="bn">DEMO INTERNATIONAL SCHOOL COLLEGE</span> (lang=bn)</div>
<div><span lang="bn" class="bn" style="font-weight:bold;">DEMO INTERNATIONAL SCHOOL COLLEGE</span></div>
<div><span lang="bn" class="bn" style="font-weight:bold;">First Term Exam &mdash; 2026</span></div>
<div><span lang="bn" class="bn" style="font-weight:bold;">First Term Exam Routine</span></div>
</body>';

$mpdf->WriteHTML($html);
$pdf = $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);
file_put_contents('storage/test_lang_bn.pdf', $pdf);
echo "Generated test_lang_bn.pdf (" . strlen($pdf) . " bytes)\n";
