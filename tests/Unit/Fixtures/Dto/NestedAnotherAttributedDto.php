<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto;

use Dezer32\Libraries\Dto\DataTransferObject;

class NestedAnotherAttributedDto extends DataTransferObject
{
    public function __construct(
        private AnotherClass $dto
    ) {
    }

    public function getDto(): AnotherClass
    {
        return $this->dto;
    }
}
