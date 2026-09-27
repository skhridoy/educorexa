<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatsSeeder extends Seeder
{
    public function run(): void
    {
        $exists = DB::table('frontend_sections')->where('key', 'stats')->exists();
        if ($exists) {
            $this->command->info('Stats section already exists — skipping.');
            return;
        }

        DB::table('frontend_sections')->insert([
            'key'        => 'stats',
            'title'      => 'Stats Section',
            'status'     => 1,
            'order'      => 2,  // after hero (order=1), before features (order=2) — we shift others below
            'content'    => json_encode([
                'schools_count'   => '৫০০+',
                'schools_label'   => 'স্কুল ও মাদ্রাসা',
                'students_count'  => '১,০০,০০০+',
                'students_label'  => 'সক্রিয় শিক্ষার্থী',
                'districts_count' => '৬৪',
                'districts_label' => 'জেলায় ব্যবহৃত',
                'support_value'   => '২৪/৭',
                'support_label'   => 'লাইভ সাপোর্ট',
            ], JSON_UNESCAPED_UNICODE),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('Stats section created successfully.');
    }
}
