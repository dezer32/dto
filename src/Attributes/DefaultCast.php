<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Attributes;

use Attribute;
use Dezer32\Libraries\Dto\Contracts\CasterInterface;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionUnionType;

#[Attribute(Attribute::TARGET_CLASS, Attribute::IS_REPEATABLE)]
class DefaultCast
{
    private array $args;

    public function __construct(
        private string $targetClass,
        private string $casterClass,
        mixed ...$args
    ) {
        $this->args = $args;
    }

    public function accepts(ReflectionParameter $property): bool
    {
        $type = $property->getType();

        /** @var ReflectionNamedType[]|null $types */
        $types = match ($type::class) {
            ReflectionNamedType::class => [$type],
            ReflectionUnionType::class => $type->getTypes(),
            default => null,
        };

        if ($types === null) {
            return false;
        }

        foreach ($types as $type) {
            if ($type->getName() !== $this->targetClass) {
                continue;
            }

            return true;
        }

        return false;
    }

    public function getCaster(): CasterInterface
    {
        return new $this->casterClass(...$this->args);
    }
}
