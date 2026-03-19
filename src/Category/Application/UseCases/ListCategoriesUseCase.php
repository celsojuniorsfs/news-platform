<?php

declare(strict_types=1);

namespace Src\Category\Application\UseCases;

use Illuminate\Support\Collection;
use Src\Category\Domain\Contracts\CategoryRepository;

final readonly class ListCategoriesUseCase
{
    public function __construct(
        private CategoryRepository $categoryRepository,
    ) {
    }

    public function execute(): Collection
    {
        return $this->categoryRepository->findAllOrdered();
    }
}

