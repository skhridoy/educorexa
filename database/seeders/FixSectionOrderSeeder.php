<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixSectionOrderSeeder extends Seeder
{
    public function run(): void
    {
        // Desired order: hero=1, stats=2, features=3, why_choose_us=4,
        //                setup-section=5, pricing=6, about=7, testimonials=8,
        //                contact=9, blogs=10
        $order = [
            'hero'          => 1,
            'stats'         => 2,
            'features'      => 3,
            'why_choose_us' => 4,
            'setup-section' => 5,
            'pricing'       => 6,
            'about'         => 7,
            'testimonials'  => 8,
            'contact'       => 9,
            'blogs'         => 10,
        ];

        foreach ($order as $key => $ord) {
            DB::table('frontend_sections')
                ->where('key', $key)
                ->update(['order' => $ord]);
        }

        $this->command->info('Section order fixed.');
    }
}
