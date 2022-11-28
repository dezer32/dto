<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto;

use Dezer32\Libraries\Dto\Attributes\Cast;
use Dezer32\Libraries\Dto\DataTransferObject;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Casters\TestStringCaster;

class AttributedDto extends DataTransferObject
{
    public function __construct(
        #[Cast(TestStringCaster::class, 'test_salt')]
        private string $text,
    ) {
    }

    public function getText(): string
    {
        return $this->text;
    }
}
