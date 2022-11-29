<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto;

use Dezer32\Libraries\Dto\Attributes\DataTransferObject;

#[DataTransferObject]
class InnerDtoByAttributeDto
{
    public function __construct(
        private DtoByAttributeDto $dto
    ) {
    }

    public function getDto(): DtoByAttributeDto
    {
        return $this->dto;
    }
}
