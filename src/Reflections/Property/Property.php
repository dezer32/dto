<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Reflections\Property;

use Dezer32\Libraries\Dto\Attributes\Cast;
use Dezer32\Libraries\Dto\Attributes\DataTransferObject;
use Dezer32\Libraries\Dto\Casters\ArrayCaster;
use Dezer32\Libraries\Dto\Contracts\DataTransferObjectInterface;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionUnionType;

class Property implements PropertyInterface
{
    public function __construct(
        private ReflectionProperty $reflectionProperty
    ) {
    }

    public function getName(): string
    {
        return $this->reflectionProperty->getName();
    }

    public function getValue(mixed $object): mixed
    {
        $this->reflectionProperty->setAccessible(true);
        $value = $this->reflectionProperty->getValue($object);
        $this->reflectionProperty->setAccessible(false);

        return $value;
    }

    public function isDto(): bool
    {
        $extractedTypes = $this->extractTypes();

        /** @var ReflectionNamedType $extractedType */
        foreach ($extractedTypes as $extractedType) {
            if (
                is_subclass_of($extractedType->getName(), DataTransferObjectInterface::class)
                || $this->isAttributedDto($extractedType->getName())
            ) {
                return true;
            }
        }

        return false;
    }

    public function isList(): bool
    {
        $attributes = $this->reflectionProperty->getAttributes(Cast::class);
        if (empty($attributes)) {
            return false;
        }

        /** @var Cast $attribute */
        $attribute = $attributes[0]->newInstance();

        return $attribute->getCasterClass() === ArrayCaster::class;
    }

    private function isAttributedDto(string $className): bool
    {
        if (!class_exists($className)) {
            return false;
        }

        $reflectionClass = new ReflectionClass($className);

        $attributes = $reflectionClass->getAttributes(DataTransferObject::class);

        return !empty($attributes);
    }

    private function extractTypes(): array
    {
        $reflectionTypes = $this->reflectionProperty->getType();

        return match ($reflectionTypes::class) {
            ReflectionNamedType::class => [$reflectionTypes],
            ReflectionUnionType::class => $reflectionTypes->getTypes()
        };
    }
}
