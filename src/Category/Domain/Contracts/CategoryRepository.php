<?php

declare(strict_types=1);

namespace Src\Category\Domain\Contracts;

use Illuminate\Support\Collection;
use Src\Category\Application\DTOs\CreateCategoryInput;
use Src\Category\Infrastructure\Models\Category;

interface CategoryRepository
{
    public function create(CreateCategoryInput $input): Category;

    public function existsByName(string $name): bool;

    public function findAllOrdered(): Collection;
}
