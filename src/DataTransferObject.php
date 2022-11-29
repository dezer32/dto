<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto;

use DateTimeInterface;
use Dezer32\Libraries\Dto\Attributes\DefaultCast;
use Dezer32\Libraries\Dto\Casters\DateTimeCaster;
use Dezer32\Libraries\Dto\Contracts\DataTransferObjectInterface;
use Dezer32\Libraries\Dto\Reflections\DtoClass\DtoClass;

#[DefaultCast(DateTimeInterface::class, DateTimeCaster::class)]
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
