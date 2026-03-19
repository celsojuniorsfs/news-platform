<?php

declare(strict_types=1);

namespace Src\News\Domain\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Src\News\Application\DTOs\CreateNewsInput;
use Src\News\Infrastructure\Models\News;

interface NewsRepository
{
    public function create(CreateNewsInput $input): News;

    public function paginateByFilters(?string $title, ?int $categoryId, int $perPage = 10): LengthAwarePaginator;
}

