<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto;

use Dezer32\Libraries\Dto\Attributes\Cast;
use Dezer32\Libraries\Dto\Attributes\DataTransferObject;
use Dezer32\Libraries\Dto\Casters\ArrayCaster;

#[DataTransferObject]
class SimpleListDto
{
    public function __construct(
        #[Cast(ArrayCaster::class, SimpleDto::class)]
        private array $list
    ) {
    }

    /** @return SimpleDto[] */
    public function getList(): array
    {
        return $this->list;
    }
}
