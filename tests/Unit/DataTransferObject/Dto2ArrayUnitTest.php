<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\DataTransferObject;

use Dezer32\Libraries\Dto\Test\Unit\AbstractUnitTestCase;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\PrimitiveDto;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\UpperNestedDto;
use Dezer32\Libraries\Dto\Transformer;

class Dto2ArrayUnitTest extends AbstractUnitTestCase
{
    /** @dataProvider dtoDataProvider */
    public function testSuccessCanConvertToArray(string $className, array $args): void
    {
        $dto = Transformer::transform($className, $args);
        self::assertEquals($args, $dto->toArray());
    }

    public function dtoDataProvider(): iterable
    {
        yield [
            PrimitiveDto::class,
            [
                'int' => $this->getFaker()->randomDigit(),
                'float' => $this->getFaker()->randomFloat(),
                'string' => $this->getFaker()->text(),
                'bool' => $this->getFaker()->boolean(),
                'array' => $this->getFaker()->shuffleArray(),
            ],
        ];
        yield [
            UpperNestedDto::class,
            [
                'inner_dto' => [
                    'nested_var' => $this->getFaker()->text(),
                ],
            ],
        ];
    }
}
