<?php
$pdf = file_get_contents('test_admit.pdf');
preg_match_all('/\/BaseFont\s*\/([^\s\/]+)/', $pdf, $m);
print_r(array_unique($m[1]));
