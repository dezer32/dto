<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\ClassTransformer;

use Dezer32\Libraries\Dto\Transformer;
use Dezer32\Libraries\Dto\Test\Unit\AbstractUnitTestCase;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\DefaultsAnotherAttributesDto;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\MomDefaultsAnotherAttributedDto;

class TransformerDefaultsDto extends AbstractUnitTestCase
{
    /** @dataProvider dtoDataProvider */
    public function testSuccessCanTransform(
        string $classDto,
        array $args,
        string $expectedString
    ): void {
        /** @var DefaultsAnotherAttributesDto $dto */
        $dto = Transformer::transform($classDto, $args);

        self::assertSame($expectedString, $dto->getClass()->getText());
    }

    public function dtoDataProvider(): iterable
    {
        yield [
            DefaultsAnotherAttributesDto::class,
            [
                'class' => [
                    'text' => 'test_text',
                ],
            ],
            'test_salt.test_text.test_salt',
        ];
        yield [
            MomDefaultsAnotherAttributedDto::class,
            [
                'class' => [
                    'text' => 'test_text',
                ],
            ],
            'test_salt.test_text.test_salt',
        ];
    }
}
