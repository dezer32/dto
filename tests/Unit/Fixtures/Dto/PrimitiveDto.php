<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto;

use Dezer32\Libraries\Dto\DataTransferObject;

class PrimitiveDto extends DataTransferObject
{
    public function __construct(
        private int $int,
        private float $float,
        private string $string,
        private bool $bool,
        private array $array,
    ) {
    }

    public function getInt(): int
    {
        return $this->int;
    }

    public function getFloat(): float
    {
        return $this->float;
    }

    public function getString(): string
    {
        return $this->string;
    }

    public function isBool(): bool
    {
        return $this->bool;
    }

    public function getArray(): array
    {
        return $this->array;
    }
}
