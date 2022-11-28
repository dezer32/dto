<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\Fixtures\Casters;

use Dezer32\Libraries\Dto\Contracts\CasterInterface;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\InnerNestedDto;

class TestStringCaster implements CasterInterface
{
    public function __construct(
        private string $salt
    ) {
    }

    public function cast(mixed $value): string
    {
        return sprintf('%s.%s.%s', $this->salt, $value, $this->salt);
    }
}
