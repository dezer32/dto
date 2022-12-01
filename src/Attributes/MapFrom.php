<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class MapFrom
{
    public function __construct(
        private string | int $name
    ) {
    }

    public function getName(): int | string
    {
        return $this->name;
    }
}
