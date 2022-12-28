<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto;

use DateTimeInterface;
use Dezer32\Libraries\Dto\Attributes\DefaultCast;
use Dezer32\Libraries\Dto\Casters\DateTimeCaster;
use Dezer32\Libraries\Dto\Contracts\DataTransferObjectInterface;
use Dezer32\Libraries\Dto\Helpers\Arr;
use Dezer32\Libraries\Dto\Helpers\VerifyDto;
use Dezer32\Libraries\Dto\Reflections\DtoClass\DtoClass;

#[DefaultCast(DateTimeInterface::class, DateTimeCaster::class)]
abstract class DataTransferObject implements DataTransferObjectInterface
{
    public function __construct(array $args)
    {
        $class = new DtoClass($this::class);

        foreach ($class->getProperties() as $property) {
            $value = Arr::getValue($args, $property->getName(), $property->getDefaultValue());
            Arr::forget($args, $property->getName());

            if ($property->isDto() && !VerifyDto::isDto($value)) {
                $value = Transformer::transform($property->getTypeName(), $value);
            } else {
                $value = $property->castValue($value);
            }

            $property->setValue($this, $value);
        }
    }

    public function toArray(): array
    {
        return ArrayTransformer::transform($this);
    }
}
