<?php

declare(strict_types=1);

namespace Src\Category\Application\DTOs;

final readonly class CreateCategoryInput
{
    public function __construct(
        public string $name,
        public ?string $slug,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: trim((string) $data['name']),
            slug: isset($data['slug']) && $data['slug'] !== ''
                ? trim((string) $data['slug'])
                : null,
        );
    }
}

