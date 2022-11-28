<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto;

use DateTimeInterface;
use Dezer32\Libraries\Dto\DataTransferObject;

class TypedDto extends DataTransferObject
{
    public function __construct(
        private DateTimeInterface $date_time,
    ) {
    }

    public function getDateTime(): DateTimeInterface
    {
        return $this->date_time;
    }
}
