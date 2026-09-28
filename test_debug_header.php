<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\School;
use App\Models\Exam;
use App\Models\Student;

$school = School::whereNotNull('logo')->first() ?? School::first();
echo "School ID: " . $school->id . "\n";
echo "School Name: " . $school->name . "\n";
echo "School App Code: " . $school->app_code . "\n";
echo "School EMIS Code: " . $school->emis_code . "\n";
echo "School EIN: " . $school->ein_number . "\n";

$exam = Exam::where('school_id', $school->id)->first() ?? Exam::first();
echo "Exam Name: " . ($exam ? $exam->name : 'none') . "\n";
