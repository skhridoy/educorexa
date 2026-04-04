<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\SiteSetting::create([
            'site_name' => 'EduCorexa',
            'email' => 'support@educorexa.com',
            'footer_text' => 'All Rights Reserved',
        ]);
    }
}
