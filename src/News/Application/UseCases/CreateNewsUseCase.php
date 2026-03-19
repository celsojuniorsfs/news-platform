<?php

declare(strict_types=1);

namespace Src\News\Application\UseCases;

use Src\News\Application\DTOs\CreateNewsInput;
use Src\News\Domain\Contracts\NewsRepository;
use Src\News\Infrastructure\Models\News;

final readonly class CreateNewsUseCase
{
    public function __construct(
        private NewsRepository $newsRepository,
    ) {
    }

    public function execute(CreateNewsInput $input): News
    {
        return $this->newsRepository->create($input);
    }
}

