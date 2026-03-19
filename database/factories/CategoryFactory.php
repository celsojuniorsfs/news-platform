<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Src\Category\Infrastructure\Models\Category;

/**
 * @extends Factory<Category>
 */
final class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Tecnologia',
            'Esportes',
            'Política',
            'Economia',
            'Saúde',
            'Educação',
            'Entretenimento',
            'Negócios',
            'Ciência',
            'Games',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
