<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto;

use Dezer32\Libraries\Dto\DataTransferObject;

class UpperNestedAttributedDto extends DataTransferObject
{
    public function __construct(
        private InnerNestedAttributedDto $inner_dto,
    ) {
    }

    public function getInnerDto(): InnerNestedAttributedDto
    {
        return $this->inner_dto;
    }
}
