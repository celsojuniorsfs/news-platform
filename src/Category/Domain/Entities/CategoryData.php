<?php

declare(strict_types=1);

namespace Src\Category\Domain\Entities;

final readonly class CategoryData
{
    public function __construct(
        public string $name,
    ) {
    }
}

