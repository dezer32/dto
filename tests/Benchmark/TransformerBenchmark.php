<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Benchmark;

use DateTimeInterface;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\AnotherClasses\AnotherAttributedClass;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\AttributedDto;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\DefaultsAnotherAttributesDto;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\DtoByAttributeDto;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\InnerDtoByAttributeDto;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\InnerNestedDto;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\MapFromIntDto;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\MapFromStringDto;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\MomDefaultsAnotherAttributedDto;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\NestedAnotherAttributedDto;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\PrimitiveDto;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\SimpleDto;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\SimpleListDto;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\TypedDto;
use Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto\UpperNestedDto;
use Dezer32\Libraries\Dto\Transformer;
use Faker\Factory;
use Faker\Generator;
use PhpBench\Attributes\ParamProviders;

class TransformerBenchmark
{
    private Generator $faker;

    #[ParamProviders('provideDtoClassWithData')]
    public function benchTransform(array $params): void
    {
        Transformer::transform($params['className'], $params['data']);
    }

    public function provideDtoClassWithData(): iterable
    {
        yield [
            'className' => SimpleDto::class,
            'data' => [
                'text' => $this->getFaker()->text(),
            ],
        ];

        yield [
            'className' => AttributedDto::class,
            'data' => [
                'text' => $this->getFaker()->text(),
            ],
        ];

        yield [
            'className' => DefaultsAnotherAttributesDto::class,
            'data' => [
                'class' => [
                    'text' => 'test_text',
                ],
            ],
        ];
        yield [
            'className' => MomDefaultsAnotherAttributedDto::class,
            'data' => [
                'class' => [
                    'text' => 'test_text',
                ],
            ],
        ];

        yield [
            'className' => DtoByAttributeDto::class,
            'data' => [
                'text' => $this->getFaker()->text(),
            ],
        ];

        yield [
            'className' => InnerDtoByAttributeDto::class,
            'data' => [
                'dto' => [
                    'text' => 'test_text',
                ],
            ],
        ];
        yield [
            'className' => InnerDtoByAttributeDto::class,
            'data' => [
                'dto' => new DtoByAttributeDto('test_text'),
            ],
        ];

        yield [
            'className' => MapFromStringDto::class,
            'data' => [
                'custom_name' => $this->getFaker()->text(),
            ],
        ];

        yield [
            'className' => MapFromIntDto::class,
            'data' => [
                $this->getFaker()->text(),
            ],
        ];

        yield [
            'className' => NestedAnotherAttributedDto::class,
            'data' => [
                'dto' => [
                    'text' => 'test_text',
                ],
            ],
        ];

        yield [
            'className' => NestedAnotherAttributedDto::class,
            'data' => [
                'dto' => new AnotherAttributedClass('test_text'),
            ],
        ];

        yield [
            'className' => UpperNestedDto::class,
            'data' => [
                'inner_dto' => new InnerNestedDto($this->getFaker()->text()),
            ],
        ];

        yield [
            'className' => UpperNestedDto::class,
            'data' => [
                'inner_dto' => [
                    'nested_var' => $this->getFaker()->text(),
                ],
            ],
        ];

        yield [
            'className' => PrimitiveDto::class,
            'data' => [
                'int' => $this->getFaker()->randomDigit(),
                'float' => $this->getFaker()->randomFloat(),
                'string' => $this->getFaker()->text(),
                'bool' => $this->getFaker()->boolean(),
                'array' => $this->getFaker()->shuffleArray(),
            ],
        ];

        yield [
            'className' => SimpleListDto::class,
            'data' => [
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

        yield [
            'className' => TypedDto::class,
            'data' => [
                'date_time' => $this->getFaker()->dateTime(),
            ],
        ];

        yield [
            'className' => TypedDto::class,
            'data' => [
                'date_time' => $this->getFaker()->dateTime()->format(DateTimeInterface::RFC3339),
            ],
        ];
    }

    private function getFaker(): Generator
    {
        return $this->faker ??= Factory::create('ru_RU');
    }
}