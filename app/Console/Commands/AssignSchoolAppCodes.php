<?php

namespace App\Console\Commands;

use App\Models\School;
use Illuminate\Console\Command;

class AssignSchoolAppCodes extends Command
{
    protected $signature = 'schools:assign-app-codes';
    protected $description = 'Assign app codes to existing schools that do not already have one';

    public function handle(): int
    {
        $schools = School::whereNull('app_code')->orWhere('app_code', '')->get();

        if ($schools->isEmpty()) {
            $this->info('All schools already have an app code.');
            return self::SUCCESS;
        }

        foreach ($schools as $school) {
            $appCode = School::generateAppCode();
            $school->app_code = $appCode;
            $school->save();
            $this->info("Assigned {$appCode} to school {$school->name} ({$school->id})");
        }

        return self::SUCCESS;
    }
}
