<?php

declare(strict_types=1);

namespace Src\Category\Domain\Exceptions;

use DomainException;

final class CategoryAlreadyExistsException extends DomainException
{
    public static function withName(string $name): self
    {
        return new self(sprintf('A categoria "%s" já existe.', $name));
    }
}
