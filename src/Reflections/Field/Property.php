<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Reflections\Field;

use ReflectionProperty;

class Property extends Field
{
    public function __construct(
        ReflectionProperty $property
    ) {
        parent::__construct($property);
    }

    public function getDefaultValue(): mixed
    {
        return $this->property->hasDefaultValue() ? $this->property->getDefaultValue() : null;
    }
}
