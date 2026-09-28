<?php
$pdf = file_get_contents('test_admit.pdf');
preg_match_all('/stream\r?\n(.*?)\r?\nendstream/s', $pdf, $matches);
foreach ($matches[1] as $idx => $stream) {
    $decompressed = @gzuncompress($stream);
    if ($decompressed !== false) {
        preg_match_all('/\((.*?)\)\s*Tj/s', $decompressed, $tj);
        if (!empty($tj[1])) {
            echo "--- Stream $idx ---\n";
            echo implode("\n", $tj[1]) . "\n";
        }
    }
}
