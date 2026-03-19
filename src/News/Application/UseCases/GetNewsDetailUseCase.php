<?php

declare(strict_types=1);

namespace Src\News\Application\UseCases;

use Src\News\Domain\Contracts\NewsRepository;
use Src\News\Domain\Exceptions\NewsNotFoundException;
use Src\News\Infrastructure\Models\News;

final readonly class GetNewsDetailUseCase
{
    public function __construct(
        private NewsRepository $newsRepository,
    ) {
    }

    public function execute(int $id): News
    {
        $news = $this->newsRepository->findByIdWithCategory($id);

        if ($news === null) {
            throw NewsNotFoundException::withId($id);
        }

        return $news;
    }
}
