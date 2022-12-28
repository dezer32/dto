<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Reflections\Field;

class Parameter extends Field
{
    public function __construct(\ReflectionParameter $property)
    {
        parent::__construct($property);
    }

    public function getDefaultValue(): mixed
    {
        return $this->property->isDefaultValueAvailable() ? $this->property->getDefaultValue() : null;
    }
}
