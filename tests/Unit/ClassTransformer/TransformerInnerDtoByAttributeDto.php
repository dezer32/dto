<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\ClassTransformer;

use Dezer32\Libraries\Dto\Transformer;
use Dezer32\Libraries\Dto\Test\Unit\AbstractUnitTestCase;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\DtoByAttributeDto;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\InnerDtoByAttributeDto;

class TransformerInnerDtoByAttributeDto extends AbstractUnitTestCase
{
    /** @dataProvider dtoDataProvicer */
    public function testSuccessCanTransform(array $args, string $expectedText): void
    {
        $dto = Transformer::transform(InnerDtoByAttributeDto::class, $args);

        self::assertSame($expectedText, $dto->getDto()->getText());
    }

    public function dtoDataProvicer(): iterable
    {
        yield [
            [
                'dto' => [
                    'text' => 'test_text',
                ],
            ],
            'test_text',
        ];
        yield [
            [
                'dto' => new DtoByAttributeDto('test_text'),
            ],
            'test_text',
        ];
    }
}
