<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\ClassTransformer;

use Dezer32\Libraries\Dto\Transformer;
use Dezer32\Libraries\Dto\Test\Unit\AbstractUnitTestCase;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\PrimitiveDto;

final class TransformerPrimitiveDtoUnitTest extends AbstractUnitTestCase
{
    /** @dataProvider dtoDataProvider */
    public function testSuccessCanTransform(array $args): void
    {
        $dto = Transformer::transform(PrimitiveDto::class, $args);

        self::assertSame($args['int'], $dto->getInt());
        self::assertSame($args['float'], $dto->getFloat());
        self::assertSame($args['string'], $dto->getString());
        self::assertSame($args['bool'], $dto->isBool());
        self::assertSame($args['array'], $dto->getArray());
    }

    public function dtoDataProvider(): iterable
    {
        yield [
            [
                'int' => $this->getFaker()->randomDigit(),
                'float' => $this->getFaker()->randomFloat(),
                'string' => $this->getFaker()->text(),
                'bool' => $this->getFaker()->boolean(),
                'array' => $this->getFaker()->shuffleArray(),
            ],
        ];
    }
}
