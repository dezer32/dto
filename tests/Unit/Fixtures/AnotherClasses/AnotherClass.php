<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\Fixtures\AnotherClasses;

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
