<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
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
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(3, true),
            'category_id' => Category::factory(),
        ];
    }
}

