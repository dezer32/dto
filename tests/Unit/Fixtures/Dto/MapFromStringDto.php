<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto;

use Dezer32\Libraries\Dto\Attributes\DataTransferObject;
use Dezer32\Libraries\Dto\Attributes\MapFrom;

#[DataTransferObject]
class MapFromStringDto
{
    public function __construct(
        #[MapFrom('custom_name')]
        private string $main_name
    ) {
    }

    public function getMainName(): string
    {
        return $this->main_name;
    }
}
