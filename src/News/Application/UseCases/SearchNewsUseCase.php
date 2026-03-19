<?php

declare(strict_types=1);

namespace Src\News\Application\UseCases;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\News\Application\DTOs\SearchNewsInput;
use Src\News\Domain\Contracts\NewsRepository;

final readonly class SearchNewsUseCase
{
    public function __construct(
        private NewsRepository $newsRepository,
    ) {
    }

    public function execute(SearchNewsInput $input): LengthAwarePaginator
    {
        return $this->newsRepository->paginateByFilters($input);
    }
}
