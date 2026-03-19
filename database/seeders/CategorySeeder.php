<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Src\Category\Infrastructure\Models\Category;

final class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
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
        ];

        foreach ($categories as $name) {
            Category::query()->updateOrCreate(
                ['name' => $name],
                ['slug' => Str::slug($name)]
            );
        }
    }
}
