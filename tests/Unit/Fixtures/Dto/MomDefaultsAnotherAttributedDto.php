<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto;

use Dezer32\Libraries\Dto\Test\Unit\Fixtures\AnotherClasses\AnotherClass;

class MomDefaultsAnotherAttributedDto extends InheritedDefaultsAnotherAttributedDto
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
