<?php

declare(strict_types=1);

namespace Src\News\Application\DTOs;

final readonly class CreateNewsInput
{
    public function __construct(
        public string $title,
        public string $content,
        public ?string $excerpt,
        public int $categoryId,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: trim((string) $data['title']),
            content: trim((string) $data['content']),
            excerpt: isset($data['excerpt']) && $data['excerpt'] !== ''
                ? trim((string) $data['excerpt'])
                : null,
            categoryId: (int) $data['category_id'],
        );
    }
}

