<?php
require __DIR__ . '/vendor/autoload.php';

$fontFile = __DIR__ . '/public/fonts/kalpurush.ttf';
$fp = fopen($fontFile, 'rb');
$header = fread($fp, 12);
$numTables = unpack('n', substr($header, 4, 2))[1];
echo "Kalpurush num tables: $numTables, file size: " . filesize($fontFile) . "\n";

// Let's test mPDF with Kalpurush on English + Bengali:
$defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];
$defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [__DIR__ . '/public/fonts']),
    'fontdata' => $fontData + [
        'kalpurush' => [
            'R' => 'kalpurush.ttf',
            'B' => 'kalpurush.ttf',
            'useOTL' => 0xFF,
        ],
    ],
]);

$mpdf->WriteHTML('<div style="font-family: kalpurush;">DEMO INTERNATIONAL SCHOOL COLLEGE (বাংলা ও ইংরেজি)</div>');
$pdf = $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);
echo "Kalpurush output length: " . strlen($pdf) . "\n";
