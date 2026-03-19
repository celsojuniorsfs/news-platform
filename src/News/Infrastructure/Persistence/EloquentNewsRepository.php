<?php

declare(strict_types=1);

namespace Src\News\Infrastructure\Persistence;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Src\News\Application\DTOs\CreateNewsInput;
use Src\News\Application\DTOs\SearchNewsInput;
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

    public function paginateByFilters(SearchNewsInput $input): LengthAwarePaginator
    {
        return News::query()
            ->with('category')
            ->when(
                $input->title !== null,
                fn ($query) => $query->where('title', 'like', '%' . $input->title . '%')
            )
            ->when(
                $input->categoryId !== null,
                fn ($query) => $query->where('category_id', $input->categoryId)
            )
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate($input->perPage)
            ->withQueryString();
    }

    public function findByIdWithCategory(int $id): ?News
    {
        return News::query()
            ->with('category')
            ->find($id);
    }
}
