<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\ClassTransformer;

use Dezer32\Libraries\Dto\ClassTransformer;
use Dezer32\Libraries\Dto\Test\Unit\AbstractUnitTestCase;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\AttributedDto;

class ClassTransformerAttributedDto extends AbstractUnitTestCase
{
    public function testSuccessCanTransform(array $args): void
    {
        $dto = ClassTransformer::transform(AttributedDto::class, $args);

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
