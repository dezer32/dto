<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\ClassTransformer;

use Dezer32\Libraries\Dto\Transformer;
use Dezer32\Libraries\Dto\Test\Unit\AbstractUnitTestCase;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\AnotherClasses\AnotherAttributedClass;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\NestedAnotherAttributedDto;

class TransformerNestedAttributedDtoUnitTest extends AbstractUnitTestCase
{
    /** @dataProvider dtoDataProvider */
    public function testSuccessCanTransform(string $expectedText, array $args): void
    {
        $dto = Transformer::transform(NestedAnotherAttributedDto::class, $args);

        self::assertSame($expectedText, $dto->getDto()->getText());
    }

    public function dtoDataProvider(): iterable
    {
        yield [
            'test_salt.test_text.test_salt',
            [
                'dto' => [
                    'text' => 'test_text',
                ],
            ],
        ];

        yield [
            'test_text',
            [
                'dto' => new AnotherAttributedClass('test_text'),
            ],
        ];
    }
}
