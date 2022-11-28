<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto;

use Dezer32\Libraries\Dto\DataTransferObject;

class InnerNestedDto extends DataTransferObject
{
    public function __construct(
        private string $nested_var,
    ) {
    }

    public function getNestedVar(): string
    {
        return $this->nested_var;
    }
}
