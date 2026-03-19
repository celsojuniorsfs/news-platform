<?php

declare(strict_types=1);

namespace Src\News\Application\DTOs;

final readonly class SearchNewsInput
{
    public function __construct(
        public ?string $title,
        public ?int $categoryId,
        public int $perPage = 10,
    ) {
    }

    public static function fromArray(array $data): self
    {
        $title = isset($data['title']) && trim((string) $data['title']) !== ''
            ? trim((string) $data['title'])
            : null;

        $categoryId = isset($data['category_id']) && $data['category_id'] !== ''
            ? (int) $data['category_id']
            : null;

        $perPage = isset($data['per_page']) && (int) $data['per_page'] > 0
            ? (int) $data['per_page']
            : 10;

        return new self(
            title: $title,
            categoryId: $categoryId,
            perPage: $perPage,
        );
    }
}
