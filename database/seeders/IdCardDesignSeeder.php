<?php

namespace Database\Seeders;

use App\Models\IdCardDesign;
use Illuminate\Database\Seeder;

class IdCardDesignSeeder extends Seeder
{
    public function run(): void
    {
        $designs = [
            [
                'name'               => 'Classic Purple',
                'slug'               => 'purple_classic',
                'header_shape'       => 'assets/images/id_card/designs/purple_classic/header_shape.png',
                'gradient_bar'       => 'assets/images/id_card/designs/purple_classic/gradient_bar.png',
                'pattern'            => 'assets/images/id_card/designs/purple_classic/pattern.png',
                'primary_color'      => '#6a1b9a',
                'badge_color'        => '#841778',
                'label_color'        => '#6a1b9a',
                'photo_border_color' => '#6a1b9a',
                'back_header_bg'     => '#f3e8ff',
                'back_header_text'   => '#6a1b9a',
                'is_active'          => true,
                'sort_order'         => 1,
            ],
            [
                'name'               => 'Royal Navy & Gold',
                'slug'               => 'navy_gold',
                'header_shape'       => 'assets/images/id_card/designs/navy_gold/header_shape.png',
                'gradient_bar'       => 'assets/images/id_card/designs/navy_gold/gradient_bar.png',
                'pattern'            => 'assets/images/id_card/designs/navy_gold/pattern.png',
                'primary_color'      => '#1e40af',
                'badge_color'        => '#0f172a',
                'label_color'        => '#1e40af',
                'photo_border_color' => '#1e40af',
                'back_header_bg'     => '#e0e7ff',
                'back_header_text'   => '#1e3a8a',
                'is_active'          => true,
                'sort_order'         => 2,
            ],
            [
                'name'               => 'Emerald Academic',
                'slug'               => 'emerald_wave',
                'header_shape'       => 'assets/images/id_card/designs/emerald_wave/header_shape.png',
                'gradient_bar'       => 'assets/images/id_card/designs/emerald_wave/gradient_bar.png',
                'pattern'            => 'assets/images/id_card/designs/emerald_wave/pattern.png',
                'primary_color'      => '#059669',
                'badge_color'        => '#065f46',
                'label_color'        => '#047857',
                'photo_border_color' => '#059669',
                'back_header_bg'     => '#ecfdf5',
                'back_header_text'   => '#065f46',
                'is_active'          => true,
                'sort_order'         => 3,
            ],
            [
                'name'               => 'Modern Cyan & Indigo',
                'slug'               => 'cyan_modern',
                'header_shape'       => 'assets/images/id_card/designs/cyan_modern/header_shape.png',
                'gradient_bar'       => 'assets/images/id_card/designs/cyan_modern/gradient_bar.png',
                'pattern'            => 'assets/images/id_card/designs/cyan_modern/pattern.png',
                'primary_color'      => '#0284c7',
                'badge_color'        => '#0369a1',
                'label_color'        => '#0284c7',
                'photo_border_color' => '#0284c7',
                'back_header_bg'     => '#e0f2fe',
                'back_header_text'   => '#0369a1',
                'is_active'          => true,
                'sort_order'         => 4,
            ],
            [
                'name'               => 'Regal Maroon & Ruby',
                'slug'               => 'maroon_regal',
                'header_shape'       => 'assets/images/id_card/designs/maroon_regal/header_shape.png',
                'gradient_bar'       => 'assets/images/id_card/designs/maroon_regal/gradient_bar.png',
                'pattern'            => 'assets/images/id_card/designs/maroon_regal/pattern.png',
                'primary_color'      => '#be123c',
                'badge_color'        => '#881337',
                'label_color'        => '#9f1239',
                'photo_border_color' => '#be123c',
                'back_header_bg'     => '#ffe4e6',
                'back_header_text'   => '#9f1239',
                'is_active'          => true,
                'sort_order'         => 5,
            ],
        ];

        foreach ($designs as $design) {
            IdCardDesign::updateOrCreate(['slug' => $design['slug']], $design);
        }
    }
}
