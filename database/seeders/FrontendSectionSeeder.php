<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\FrontendSection;

class FrontendSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // php artisan make:seeder FrontendSectionSeeder
    public function run(): void
    {
        $sections = [
            ['key' => 'hero', 'title' => 'Hero Section', 'order' => 1],
            ['key' => 'category_module', 'title' => 'Category Module', 'order' => 2],
            ['key' => 'why_choose_us', 'title' => 'Why Choose Us', 'order' => 3],
            ['key' => 'setup-section', 'title' => 'Setup Section', 'order' => 4],
            ['key' => 'pricing', 'title' => 'Pricing Table', 'order' => 5],
            ['key' => 'about', 'title' => 'About Us', 'order' => 6],
            ['key' => 'testimonials', 'title' => 'Testimonials', 'order' => 7],
            ['key' => 'contact', 'title' => 'Contact Section', 'order' => 8],
        ];

        foreach ($sections as $section) {
            FrontendSection::updateOrCreate(['key' => $section['key']], $section);
        }
    }
}
