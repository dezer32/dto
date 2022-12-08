<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto;

use Dezer32\Libraries\Dto\DataTransferObject;

class WithoutConstructorDto extends DataTransferObject
{
    private string $string;

    public function getString(): string
    {
        return $this->string;
    }
}
