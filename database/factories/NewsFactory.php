<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Src\Category\Infrastructure\Models\Category;
use Src\News\Infrastructure\Models\News;

/**
 * @extends Factory<News>
 */
final class NewsFactory extends Factory
{
    protected $model = News::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(rand(4, 8));
        $content = fake()->paragraphs(rand(3, 6), true);

        return [
            'title' => Str::title($title),
            'content' => $content,
            'excerpt' => Str::limit($content, 180),
            'category_id' => Category::factory(),
            'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
            'updated_at' => now(),
        ];
    }
}
