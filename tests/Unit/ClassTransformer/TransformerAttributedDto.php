<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\ClassTransformer;

use Dezer32\Libraries\Dto\Transformer;
use Dezer32\Libraries\Dto\Test\Unit\AbstractUnitTestCase;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\AttributedDto;

class TransformerAttributedDto extends AbstractUnitTestCase
{
    /** @dataProvider dtoDataProvider */
    public function testSuccessCanTransform(array $args): void
    {
        $dto = Transformer::transform(AttributedDto::class, $args);

        self::assertSame(
            sprintf('test_salt.%s.test_salt', $args['text']),
            $dto->getText()
        );
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
