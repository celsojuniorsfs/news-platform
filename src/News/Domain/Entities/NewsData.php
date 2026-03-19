<?php

declare(strict_types=1);

namespace Src\News\Domain\Entities;

final readonly class NewsData
{
    public function __construct(
        public string $title,
        public string $content,
        public int $categoryId,
    ) {
    }
}

