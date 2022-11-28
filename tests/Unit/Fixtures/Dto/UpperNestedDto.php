<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto;

use Dezer32\Libraries\Dto\DataTransferObject;

class UpperNestedDto extends DataTransferObject
{
    public function __construct(
        private InnerNestedDto $inner_dto,
    ) {
    }

    public function getInnerDto(): InnerNestedDto
    {
        return $this->inner_dto;
    }
}
