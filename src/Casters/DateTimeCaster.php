<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Casters;

use DateTime;
use DateTimeInterface;
use Dezer32\Libraries\Dto\Contracts\CasterInterface;

class DateTimeCaster implements CasterInterface
{
    public function cast(mixed $value): DateTimeInterface|null
    {
        if ($value === null) {
            return null;
        }

        if (is_a($value, DateTimeInterface::class) || is_subclass_of($value, DateTimeInterface::class)) {
            return $value;
        }

        return new DateTime($value);
    }
}
