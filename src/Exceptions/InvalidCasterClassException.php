<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Exceptions;

class InvalidCasterClassException extends DtoException
{
    private const MESSAGE = 'Class "%s" does not inherit "CasterInterface"';

    public function __construct(string $casterClass)
    {
        parent::__construct(sprintf(self::MESSAGE, $casterClass));
    }
}
