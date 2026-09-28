<?php
require 'vendor/autoload.php';
$bootstrap = require __DIR__ . '/bootstrap/app.php';
$kernel = $bootstrap->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$schools = \App\Models\School::all(['id', 'name', 'address', 'app_code', 'emis_code', 'ein_number']);
foreach ($schools as $s) {
    echo $s->id . ' | ' . $s->name . ' | ' . $s->address . ' | ' . $s->app_code . ' | ' . $s->ein_number . PHP_EOL;
}

$exams = \App\Models\Exam::all(['id', 'school_id', 'name']);
foreach ($exams as $e) {
    echo "Exam: " . $e->id . " | School: " . $e->school_id . " | " . $e->name . PHP_EOL;
}
