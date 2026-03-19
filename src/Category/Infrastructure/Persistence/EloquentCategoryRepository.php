<?php

declare(strict_types=1);

namespace Src\Category\Infrastructure\Persistence;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Src\Category\Application\DTOs\CreateCategoryInput;
use Src\Category\Domain\Contracts\CategoryRepository;
use Src\Category\Infrastructure\Models\Category;

final class EloquentCategoryRepository implements CategoryRepository
{
    public function create(CreateCategoryInput $input): Category
    {
        return Category::query()->create([
            'name' => $input->name,
            'slug' => $input->slug ?? Str::slug($input->name),
        ]);
    }

    public function existsByName(string $name): bool
    {
        return Category::query()
            ->whereRaw('LOWER(name) = ?', [mb_strtolower(trim($name))])
            ->exists();
    }

    public function findAllOrdered(): Collection
    {
        return Category::query()
            ->orderBy('name')
            ->get();
    }
}
