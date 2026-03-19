<?php

declare(strict_types=1);

namespace Src\News\Application\DTOs;

final readonly class CreateNewsInput
{
    public function __construct(
        public string $title,
        public string $content,
        public int $categoryId,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: (string) $data['title'],
            content: (string) $data['content'],
            categoryId: (int) $data['category_id'],
        );
    }
}

