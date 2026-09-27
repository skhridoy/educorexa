<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddMissingSectionsSeeder extends Seeder
{
    public function run(): void
    {
        $toAdd = [
            [
                'key'    => 'newsletter',
                'title'  => 'Newsletter Section',
                'order'  => 11,
                'status' => 1,
            ],
            [
                'key'    => 'cta',
                'title'  => 'CTA Section',
                'order'  => 12,
                'status' => 1,
            ],
        ];

        foreach ($toAdd as $section) {
            $exists = DB::table('frontend_sections')->where('key', $section['key'])->exists();
            if (!$exists) {
                DB::table('frontend_sections')->insert(array_merge($section, [
                    'content'    => '{}',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
                $this->command->info("Added section: {$section['key']}");
            } else {
                $this->command->info("Section already exists: {$section['key']}");
            }
        }
    }
}
