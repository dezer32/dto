<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto;

use Dezer32\Libraries\Dto\Attributes\Cast;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Casters\TestAnotherClassCaster;

#[Cast(TestAnotherClassCaster::class, 'test_salt')]
class AnotherClass
{
    public function __construct(
        private string $text
    ) {
    }

    public function getText(): string
    {
        return $this->text;
    }
}
