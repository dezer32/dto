<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto;

use Dezer32\Libraries\Dto\Contracts\DataTransferObjectInterface;
use Dezer32\Libraries\Dto\Reflections\DtoClass\DtoClass;

abstract class DataTransferObject implements DataTransferObjectInterface
{
    public function toArray(): array
    {
        $class = new DtoClass(static::class);

        $data = [];
        foreach ($class->getProperties() as $property) {
            $value = $property->getValue($this);
            if ($property->isDto()) {
                $value = $value->toArray();
            }
            $data[$property->getName()] = $value;
        }

        return $data;
    }
}
