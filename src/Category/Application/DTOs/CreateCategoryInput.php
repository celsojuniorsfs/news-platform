<?php

declare(strict_types=1);

namespace Src\Category\Application\DTOs;

final readonly class CreateCategoryInput
{
    public function __construct(
        public string $name,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: (string) $data['name'],
        );
    }
}

