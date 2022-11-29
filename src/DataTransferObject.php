<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto;

use DateTimeInterface;
use Dezer32\Libraries\Dto\Attributes\DefaultCast;
use Dezer32\Libraries\Dto\Casters\DateTimeCaster;
use Dezer32\Libraries\Dto\Contracts\DataTransferObjectInterface;

#[DefaultCast(DateTimeInterface::class, DateTimeCaster::class)]
abstract class DataTransferObject implements DataTransferObjectInterface
{
    public function toArray(): array
    {
        return ArrayTransformer::transform($this);
    }
}
