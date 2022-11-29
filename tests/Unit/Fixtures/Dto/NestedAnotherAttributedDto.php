<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto;

use Dezer32\Libraries\Dto\DataTransferObject;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\AnotherClasses\AnotherAttributedClass;

class NestedAnotherAttributedDto extends DataTransferObject
{
    public function __construct(
        private AnotherAttributedClass $dto
    ) {
    }

    public function getDto(): AnotherAttributedClass
    {
        return $this->dto;
    }
}
