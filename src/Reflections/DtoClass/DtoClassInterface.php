<?php

namespace Dezer32\Libraries\Dto\Reflections\DtoClass;

use Dezer32\Libraries\Dto\Contracts\DataTransferObjectInterface;
use Dezer32\Libraries\Dto\Reflections\Parameter\ParameterInterface;

interface DtoClassInterface
{
    public function make(array $args): DataTransferObjectInterface;

    /**
     * @return ParameterInterface[]
     */
    public function getParameters(): array;
}
