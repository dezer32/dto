<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\ClassTransformer;

use Dezer32\Libraries\Dto\ArrayTransformer;
use Dezer32\Libraries\Dto\Test\Unit\AbstractUnitTestCase;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\SimpleListDto;
use Dezer32\Libraries\Dto\Transformer;

class TransformerSimpleList extends AbstractUnitTestCase
{
    /** @dataProvider dtoDataProvider */
    public function testSuccessCanTransform(array $args): void
    {
        $dto = Transformer::transform(SimpleListDto::class, $args);

        self::assertEquals($args, ArrayTransformer::transform($dto));
    }

    public function dtoDataProvider(): iterable
    {
        yield [
            [
                'list' => [
                    [
                        'text' => $this->getFaker()->text(),
                    ],
                    [
                        'text' => $this->getFaker()->text(),
                    ],
                    [
                        'text' => $this->getFaker()->text(),
                    ],
                ],
            ],
        ];
    }
}
