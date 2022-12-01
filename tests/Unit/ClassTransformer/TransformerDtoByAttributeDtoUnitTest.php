<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\ClassTransformer;

use Dezer32\Libraries\Dto\Transformer;
use Dezer32\Libraries\Dto\Test\Unit\AbstractUnitTestCase;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\DtoByAttributeDto;

class TransformerDtoByAttributeDtoUnitTest extends AbstractUnitTestCase
{
    /** @dataProvider dtoDataProvider */
    public function testSuccessCanTransform(array $args): void
    {
        $dto = Transformer::transform(DtoByAttributeDto::class, $args);

        self::assertSame($args['text'], $dto->getText());
    }

    public function dtoDataProvider(): iterable
    {
        yield [
            [
                'text' => $this->getFaker()->text(),
            ],
        ];
    }
}
