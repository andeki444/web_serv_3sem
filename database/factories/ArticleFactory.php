<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => fake()->date(),
            'name' => fake()->sentence(4),
            'short_desc' => fake()->paragraph(1),
            'desc' => fake()->paragraph(3),
            'preview_image' => 'preview.jpg',
            'full_image' => 'full.jpeg',
        ];
    }
}
