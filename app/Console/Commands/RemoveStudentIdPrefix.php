<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RemoveStudentIdPrefix extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'students:remove-prefix
                            {prefix=STD- : The prefix to remove from student IDs}
                            {--dry-run : Show what would change without actually updating}';

    /**
     * The console command description.
     */
    protected $description = 'Remove "STD-" prefix from all student_id values in the database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $prefix = $this->argument('prefix');
        $isDryRun = $this->option('dry-run');

        // Count affected rows
        $count = DB::table('students')
            ->where('student_id', 'like', $prefix . '%')
            ->count();

        if ($count === 0) {
            $this->info("✅ কোনো স্টুডেন্ট আইডিতে \"{$prefix}\" প্রিফিক্স পাওয়া যায়নি। কিছু পরিবর্তন করা হয়নি।");
            return self::SUCCESS;
        }

        // Show sample before
        $samples = DB::table('students')
            ->where('student_id', 'like', $prefix . '%')
            ->limit(5)
            ->pluck('student_id');

        $this->table(['আগের Student ID (নমুনা)'], $samples->map(fn($id) => [$id])->toArray());
        $this->warn("মোট {$count} জন স্টুডেন্টের আইডি পরিবর্তন হবে।");

        if ($isDryRun) {
            $this->info('⚠️  Dry-run মোড: কোনো পরিবর্তন করা হয়নি।');
            return self::SUCCESS;
        }

        // Confirm before update
        if (!$this->confirm("আপনি কি নিশ্চিত? {$count} জন স্টুডেন্টের আইডি থেকে \"{$prefix}\" মুছে ফেলা হবে।", true)) {
            $this->info('বাতিল করা হয়েছে।');
            return self::SUCCESS;
        }

        // Perform the update
        DB::table('students')
            ->where('student_id', 'like', $prefix . '%')
            ->update([
                'student_id' => DB::raw("REPLACE(student_id, '{$prefix}', '')")
            ]);

        // Verify
        $remaining = DB::table('students')
            ->where('student_id', 'like', $prefix . '%')
            ->count();

        if ($remaining === 0) {
            // Show sample after
            $updatedSamples = DB::table('students')
                ->whereNotLike('student_id', $prefix . '%')
                ->limit(5)
                ->pluck('student_id');

            $this->table(['পরিবর্তিত Student ID (নমুনা)'], $updatedSamples->map(fn($id) => [$id])->toArray());
            $this->info("✅ সফলভাবে {$count} জন স্টুডেন্টের আইডি থেকে \"{$prefix}\" প্রিফিক্স মুছে ফেলা হয়েছে।");
        } else {
            $this->error("❌ {$remaining} জন স্টুডেন্টের আইডি এখনও আপডেট হয়নি।");
            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
