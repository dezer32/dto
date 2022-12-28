<?php

namespace Dezer32\Libraries\Dto\Reflections\DtoClass;

use Dezer32\Libraries\Dto\Reflections\Field\Parameter;
use Dezer32\Libraries\Dto\Reflections\Field\Property;

interface DtoClassInterface
{
    public function make(array $args): object;

    /**
     * @return Parameter[]
     */
    public function getParameters(): array;

    /**
     * @return Property[]
     */
    public function getProperties(): array;
}
