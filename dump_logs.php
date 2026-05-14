<?php
$logFile = __DIR__ . '/storage/logs/laravel.log';
if (!file_exists($logFile)) {
    file_put_contents(__DIR__ . '/public/last_logs.txt', 'No log file found.');
    exit;
}
$lines = file($logFile);
$last100 = array_slice($lines, -100);
file_put_contents(__DIR__ . '/public/last_logs.txt', implode("", $last100));
echo "Logs dumped";
