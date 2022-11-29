<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto;

use Dezer32\Libraries\Dto\Attributes\DefaultCast;
use Dezer32\Libraries\Dto\DataTransferObject;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\AnotherClasses\AnotherClass;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Casters\TestAnotherClassCaster;

#[DefaultCast(AnotherClass::class, TestAnotherClassCaster::class, 'test_salt')]
class DefaultsAnotherAttributesDto extends DataTransferObject
{
    public function __construct(
        private AnotherClass $class
    ) {
    }

    public function getClass(): AnotherClass
    {
        return $this->class;
    }
}
