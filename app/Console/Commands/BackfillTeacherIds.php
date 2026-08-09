<?php

namespace App\Console\Commands;

use App\Models\School;
use App\Models\Teacher;
use Illuminate\Console\Command;

class BackfillTeacherIds extends Command
{
    protected $signature = 'teachers:backfill-ids';
    protected $description = 'Backfill teacher IDs for existing teachers using the last 4 digits of the app code';

    public function handle(): int
    {
        $teachers = Teacher::with('school')->get();

        foreach ($teachers as $teacher) {
            $shouldUpdate = empty($teacher->teacher_id);

            if (!$shouldUpdate) {
                continue;
            }

            $newTeacherId = Teacher::generateTeacherId($teacher->school_id);
            $teacher->teacher_id = $newTeacherId;
            $teacher->save();
        }

        $this->info('Teacher IDs backfilled successfully.');
        return self::SUCCESS;
    }
}
