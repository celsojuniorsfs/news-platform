<?php

declare(strict_types=1);

namespace Src\News\Application\UseCases;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\News\Domain\Contracts\NewsRepository;

final readonly class SearchNewsUseCase
{
    public function __construct(
        private NewsRepository $newsRepository,
    ) {
    }

    public function execute(?string $title, ?int $categoryId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->newsRepository->paginateByFilters(
            title: $title,
            categoryId: $categoryId,
            perPage: $perPage,
        );
    }
}

