<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\ClassTransformer;

use Dezer32\Libraries\Dto\ClassTransformer;
use Dezer32\Libraries\Dto\Test\Unit\AbstractUnitTestCase;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\InnerNestedDto;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\UpperNestedDto;

class ClassTransformerNestedDtoUnitTest extends AbstractUnitTestCase
{
    /** @dataProvider dtoDataProvider */
    public function testSuccessCanTransform(array $args): void
    {
        $dto = ClassTransformer::transform(UpperNestedDto::class, $args);

        self::assertInstanceOf(InnerNestedDto::class, $dto->getInnerDto());
        self::assertIsString($dto->getInnerDto()->getNestedVar());
    }

    public function dtoDataProvider(): iterable
    {
        yield [
            [
                'inner_dto' => new InnerNestedDto($this->getFaker()->text()),
            ],
        ];

        yield [
            [
                'inner_dto' => [
                    'nested_var' => $this->getFaker()->text(),
                ],
            ],
        ];
    }
}
