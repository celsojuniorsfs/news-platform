<?php

declare(strict_types=1);

namespace Src\News\Domain\Exceptions;

use DomainException;

final class NewsNotFoundException extends DomainException
{
    public static function withId(int $id): self
    {
        return new self(sprintf('A notícia de ID %d não foi encontrada.', $id));
    }
}
