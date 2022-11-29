<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Attributes;

use Attribute;
use Dezer32\Libraries\Dto\Contracts\CasterInterface;
use Dezer32\Libraries\Dto\Exceptions\InvalidCasterClassException;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Cast
{
    private array $args;

    public function __construct(
        private string $casterClass,
        mixed ...$args
    ) {
        if (!is_subclass_of($this->casterClass, CasterInterface::class)) {
            throw new InvalidCasterClassException($this->casterClass);
        }

        $this->args = $args;
    }

    public function getCaster(): CasterInterface
    {
        return new $this->casterClass(...$this->args);
    }
}
