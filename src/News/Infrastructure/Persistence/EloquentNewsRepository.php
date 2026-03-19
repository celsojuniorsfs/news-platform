<?php

declare(strict_types=1);

namespace Src\News\Infrastructure\Persistence;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Src\News\Application\DTOs\CreateNewsInput;
use Src\News\Domain\Contracts\NewsRepository;
use Src\News\Infrastructure\Models\News;

final class EloquentNewsRepository implements NewsRepository
{
    public function create(CreateNewsInput $input): News
    {
        return News::query()->create([
            'title' => $input->title,
            'content' => $input->content,
            'excerpt' => $input->excerpt ?? Str::limit(trim(strip_tags($input->content)), 180),
            'category_id' => $input->categoryId,
        ]);
    }

    public function paginateByFilters(?string $title, ?int $categoryId, int $perPage = 10): LengthAwarePaginator
    {
        return News::query()
            ->with('category')
            ->when(
                filled($title),
                fn ($query) => $query->where('title', 'like', '%' . trim((string) $title) . '%')
            )
            ->when(
                filled($categoryId),
                fn ($query) => $query->where('category_id', $categoryId)
            )
            ->latest('id')
            ->paginate($perPage)
            ->withQueryString();
    }
}

