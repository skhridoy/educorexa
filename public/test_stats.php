<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$startOfWeek = now()->startOfWeek(\Carbon\Carbon::SATURDAY);
$endOfWeek = now()->endOfWeek(\Carbon\Carbon::FRIDAY);
echo "Start: " . $startOfWeek->toDateTimeString() . "\n";
echo "End: " . $endOfWeek->toDateTimeString() . "\n";

$weeklyAttendanceRaw = \App\Models\Attendance::whereBetween('date', [$startOfWeek, $endOfWeek])
            ->select(
                \DB::raw("DATE_FORMAT(date, '%a') as day_name"),
                \DB::raw("COUNT(*) as total_count"),
                \DB::raw("SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present_count")
            )
            ->groupBy('day_name', 'date')
            ->orderBy('date')
            ->get()
            ->keyBy('day_name');

echo "Weekly raw:\n";
print_r($weeklyAttendanceRaw->toArray());

$schoolId = \App\Models\School::first()->id ?? 1;
$allData = \App\Models\Attendance::get()->toArray();
echo "All Data Count: " . count($allData) . "\n";
