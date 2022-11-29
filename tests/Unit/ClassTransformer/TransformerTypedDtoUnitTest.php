<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\ClassTransformer;

use DateTimeInterface;
use Dezer32\Libraries\Dto\Test\Unit\AbstractUnitTestCase;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\TypedDto;
use Dezer32\Libraries\Dto\Transformer;

final class TransformerTypedDtoUnitTest extends AbstractUnitTestCase
{
    /** @dataProvider dtoDataProvider */
    public function testSuccessCanTransform(array $args, DateTimeInterface $expectedDateTime): void
    {
        $dto = Transformer::transform(TypedDto::class, $args);

        self::assertSame($expectedDateTime->getTimestamp(), $dto->getDateTime()->getTimestamp());
    }

    public function dtoDataProvider(): iterable
    {
        $dateTime = $this->getFaker()->dateTime();

        yield [
            [
                'date_time' => $dateTime,
            ],
            $dateTime,
        ];

        yield [
            [
                'date_time' => $dateTime->format(DateTimeInterface::RFC3339),
            ],
            $dateTime,
        ];
    }
}
