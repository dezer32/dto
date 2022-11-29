<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\Fixtures\AnotherClasses;

use Dezer32\Libraries\Dto\Attributes\Cast;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Casters\TestAnotherAttributedClassCaster;

#[Cast(TestAnotherAttributedClassCaster::class, 'test_salt')]
class AnotherAttributedClass
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
