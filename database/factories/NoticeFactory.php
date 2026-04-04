<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Notice;

class NoticeFactory extends Factory
{
    protected $model = Notice::class;

    public function definition(): array
    {
        return [
            'school_id' => 1, // change dynamically if needed
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraphs(2, true),
        ];
    }
}
