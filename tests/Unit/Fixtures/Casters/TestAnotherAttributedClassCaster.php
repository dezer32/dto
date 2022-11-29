<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\Fixtures\Casters;

use Dezer32\Libraries\Dto\Contracts\CasterInterface;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\AnotherClasses\AnotherAttributedClass;

class TestAnotherAttributedClassCaster implements CasterInterface
{
    public function __construct(
        private string $salt,
    ) {
    }

    public function cast(mixed $value): AnotherAttributedClass
    {
        if (is_a($value, AnotherAttributedClass::class)) {
            return $value;
        }

        $text = sprintf('%s.%s.%s', $this->salt, $value['text'], $this->salt);

        return new AnotherAttributedClass($text);
    }
}
