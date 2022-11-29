<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\ClassTransformer;

use Dezer32\Libraries\Dto\Transformer;
use Dezer32\Libraries\Dto\Test\Unit\AbstractUnitTestCase;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\TypedDto;

final class TransformerTypedDtoUnitTest extends AbstractUnitTestCase
{
    /** @dataProvider dtoDataProvider */
    public function testSuccessCanTransform(array $args): void
    {
        $dto = Transformer::transform(TypedDto::class, $args);

        self::assertSame($args['date_time'], $dto->getDateTime());
    }

    public function dtoDataProvider(): iterable
    {
        yield [
            [
                'date_time' => $this->getFaker()->dateTime(),
            ],
        ];
    }
}
