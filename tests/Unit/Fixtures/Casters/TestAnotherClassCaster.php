<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\Fixtures\Casters;

use Dezer32\Libraries\Dto\Contracts\CasterInterface;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\AnotherClass;

class TestAnotherClassCaster implements CasterInterface
{
    public function __construct(
        private string $salt,
    ) {
    }

    public function cast(mixed $value): AnotherClass
    {
        if (is_a($value, AnotherClass::class)) {
            return $value;
        }

        $text = sprintf('%s.%s.%s', $this->salt, $value['text'], $this->salt);

        return new AnotherClass($text);
    }
}
