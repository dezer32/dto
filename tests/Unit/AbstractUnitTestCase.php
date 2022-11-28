<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit;

use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

abstract class AbstractUnitTestCase extends TestCase
{
    protected Generator $faker;

    protected function getFaker(string $locale = 'ru_RU'): Generator
    {
        return $this->faker ??= Factory::create($locale);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->getFaker();
    }
}
