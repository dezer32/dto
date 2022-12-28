<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\DataTransferObject;

use Dezer32\Libraries\Dto\Test\Unit\AbstractUnitTestCase;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\WithoutConstructorDto;

class DataTransferObjectConstructUnitTest extends AbstractUnitTestCase
{
    public function testSuccessCanMakeDto(): void
    {
        $testString = $this->faker->text();
        $dto = new WithoutConstructorDto(['string' => $testString]);

        self::assertSame($testString, $dto->getString());
    }
}
