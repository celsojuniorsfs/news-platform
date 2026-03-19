<?php

declare(strict_types=1);

namespace Src\Category\Application\UseCases;

use Src\Category\Application\DTOs\CreateCategoryInput;
use Src\Category\Domain\Contracts\CategoryRepository;
use Src\Category\Domain\Exceptions\CategoryAlreadyExistsException;
use Src\Category\Infrastructure\Models\Category;

final readonly class CreateCategoryUseCase
{
    public function __construct(
        private CategoryRepository $categoryRepository,
    ) {
    }

    public function execute(CreateCategoryInput $input): Category
    {
        if ($this->categoryRepository->existsByName($input->name)) {
            throw CategoryAlreadyExistsException::withName($input->name);
        }

        return $this->categoryRepository->create($input);
    }
}
