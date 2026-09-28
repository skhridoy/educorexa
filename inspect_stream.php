<?php
$pdf = file_get_contents('test_admit.pdf');
// Find stream objects and decompress them if needed
preg_match_all('/stream\r?\n(.*?)\r?\nendstream/s', $pdf, $matches);
foreach ($matches[1] as $idx => $stream) {
    $decompressed = @gzuncompress($stream);
    if ($decompressed !== false) {
        if (str_contains($decompressed, 'Demo') || str_contains($decompressed, 'SCHOOL') || str_contains($decompressed, 'Tf') || str_contains($decompressed, 'TJ')) {
            echo "Stream $idx matches:\n";
            // print lines with font switching (/F...)
            foreach (explode("\n", $decompressed) as $line) {
                if (str_contains($line, 'Tf') || str_contains($line, 'Tj') || str_contains($line, 'TJ') || str_contains($line, 'ET') || str_contains($line, 'BT')) {
                    echo substr($line, 0, 100) . "\n";
                }
            }
            break;
        }
    }
}
