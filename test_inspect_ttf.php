<?php
require __DIR__ . '/vendor/autoload.php';

$fontFile = __DIR__ . '/public/fonts/SolaimanLipi.ttf';
$fp = fopen($fontFile, 'rb');
$header = fread($fp, 12);
$numTables = unpack('n', substr($header, 4, 2))[1];

echo "Num tables: $numTables\n";
$cmapOffset = 0;
for ($i = 0; $i < $numTables; $i++) {
    $tag = fread($fp, 4);
    $checkSum = fread($fp, 4);
    $offset = unpack('N', fread($fp, 4))[1];
    $length = unpack('N', fread($fp, 4))[1];
    if ($tag === 'cmap') {
        $cmapOffset = $offset;
        break;
    }
}

echo "cmap offset: $cmapOffset\n";
// Let's test mPDF font metrics generator on SolaimanLipi.ttf!
$ttf = new \Mpdf\File\Stream($fontFile);
echo "File size: " . filesize($fontFile) . "\n";
