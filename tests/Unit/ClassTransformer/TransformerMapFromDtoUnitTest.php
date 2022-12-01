<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\ClassTransformer;

use Dezer32\Libraries\Dto\Test\Unit\AbstractUnitTestCase;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\MapFromIntDto;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\MapFromStringDto;
use Dezer32\Libraries\Dto\Transformer;

class TransformerMapFromDtoUnitTest extends AbstractUnitTestCase
{
    public function testSuccessCanMapFromString(): void
    {
        $testString = $this->faker->text();
        $dto = Transformer::transform(MapFromStringDto::class, ['custom_name' => $testString]);

        self::assertSame($testString, $dto->getMainName());
    }

    public function testSuccessCanMapFromInt(): void
    {
        $testString = $this->faker->text();
        $dto = Transformer::transform(MapFromIntDto::class, [$testString]);

        self::assertSame($testString, $dto->getMainName());
    }
}
