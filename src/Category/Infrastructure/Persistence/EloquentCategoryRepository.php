<?php

declare(strict_types=1);

namespace Src\Category\Infrastructure\Persistence;

use Illuminate\Support\Collection;
use Src\Category\Application\DTOs\CreateCategoryInput;
use Src\Category\Domain\Contracts\CategoryRepository;
use Src\Category\Infrastructure\Models\Category;

final class EloquentCategoryRepository implements CategoryRepository
{
    public function create(CreateCategoryInput $input): Category
    {
        return Category::query()->create([
            'name' => $input->name,
        ]);
    }

    public function findAllOrdered(): Collection
    {
        return Category::query()
            ->orderBy('name')
            ->get();
    }
}

