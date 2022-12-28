<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Helpers;

use Dezer32\Libraries\Dto\Attributes\Cast;
use Dezer32\Libraries\Dto\Attributes\DefaultCast;
use Dezer32\Libraries\Dto\Contracts\CasterInterface;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionProperty;
use ReflectionUnionType;

class CasterResolver
{
    public function __construct(
        private ReflectionParameter | ReflectionProperty $reflectionParameter,
    ) {
    }

    public static function resolve(
        ReflectionParameter | ReflectionProperty $reflectionParameter
    ): ?CasterInterface {
        return (new static($reflectionParameter))->getCaster();
    }

    private function getCaster(): ?CasterInterface
    {
        $attributes = $this->reflectionParameter->getAttributes(Cast::class);

        if (empty($attributes)) {
            $attributes = $this->resolveCasterFromType();
        }

        if (empty($attributes)) {
            return $this->resolveCasterFromDefaults();
        }

        /** @var Cast $attribute */
        $attribute = $attributes[0]->newInstance();

        return $attribute->getCaster();
    }

    private function resolveCasterFromType(): array
    {
        $reflectionTypes = $this->reflectionParameter->getType();

        $extractTypes = match ($reflectionTypes::class) {
            ReflectionNamedType::class => [$reflectionTypes],
            ReflectionUnionType::class => $reflectionTypes->getTypes()
        };

        foreach ($extractTypes as $type) {
            $typeName = $type->getName();

            if (!class_exists($typeName)) {
                continue;
            }

            $class = new ReflectionClass($typeName);

            do {
                $attributes = $class->getAttributes(Cast::class);
                $class = $class->getParentClass();
            } while (empty($attributes) && $class !== false);

            if (!empty($attributes)) {
                return $attributes;
            }
        }

        return [];
    }

    private function resolveCasterFromDefaults(): ?CasterInterface
    {
        $reflectionClass = $this->reflectionParameter->getDeclaringClass();

        $defaultCastAttributes = [];
        do {
            array_push($defaultCastAttributes, ...$reflectionClass->getAttributes(DefaultCast::class));
            $reflectionClass = $reflectionClass->getParentClass();
        } while ($reflectionClass !== false);

        if (empty($defaultCastAttributes)) {
            return null;
        }

        /** @var ReflectionAttribute $attribute */
        foreach ($defaultCastAttributes as $attribute) {
            /** @var DefaultCast $defaultCast */
            $defaultCast = $attribute->newInstance();

            if ($defaultCast->accepts($this->reflectionParameter)) {
                return $defaultCast->getCaster();
            }
        }

        return null;
    }
}
