<?php

namespace Dezer32\Libraries\Dto\Reflections\DtoClass;

use Dezer32\Libraries\Dto\Reflections\Parameter\ParameterInterface;
use Dezer32\Libraries\Dto\Reflections\Property\PropertyInterface;

interface DtoClassInterface
{
    public function make(array $args): object;

    /**
     * @return ParameterInterface[]
     */
    public function getParameters(): array;

    /**
     * @return PropertyInterface[]
     */
    public function getProperties(): array;
}
