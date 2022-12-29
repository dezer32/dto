<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Reflections\Field;

use Dezer32\Libraries\Dto\Attributes\Cast;
use Dezer32\Libraries\Dto\Attributes\MapFrom;
use Dezer32\Libraries\Dto\Casters\ArrayCaster;
use Dezer32\Libraries\Dto\Contracts\CasterInterface;
use Dezer32\Libraries\Dto\Contracts\DataTransferObjectInterface;
use Dezer32\Libraries\Dto\Exceptions\DtoException;
use Dezer32\Libraries\Dto\Helpers\CasterResolver;
use Dezer32\Libraries\Dto\Helpers\VerifyDto;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionProperty;
use ReflectionUnionType;

class Field implements FieldInterface
{
    protected ?CasterInterface $caster;
    protected string|int $name;
    protected ReflectionProperty|ReflectionParameter $property;

    public function __construct(
        ReflectionProperty|ReflectionParameter $property
    ) {
        $this->property = $property;
        $this->guard();
        $this->caster = CasterResolver::resolve($this->property);
    }

    public function castValue(mixed $value): mixed
    {
        if ($this->caster !== null) {
            $value = $this->caster->cast($value);
        }

        return $value;
    }

    public function getName(): string|int
    {
        return $this->name ??= $this->resolveMappedName();
    }

    public function getTypeName(): string
    {
        return $this->property->getType()?->getName();
    }

    public function getDefaultValue(): mixed
    {
        return $this->property->getDefaultValue();
    }

    public function getValue(mixed $object): mixed
    {
        $this->property->setAccessible(true);
        $value = $this->property->getValue($object);
        $this->property->setAccessible(false);

        return $value;
    }

    public function setValue(DataTransferObjectInterface $object, mixed $value = null): void
    {
        $this->property->setAccessible(true);
        $this->property->setValue($object, $value);
        $this->property->setAccessible(false);
    }

    public function isList(): bool
    {
        $attribute = $this->getAttributeInstance(Cast::class);

        if ($attribute === null) {
            return false;
        }

        return $attribute->getCasterClass() === ArrayCaster::class;
    }

    public function isDto(): bool
    {
        $types = $this->extractTypes();
        /** @var ReflectionNamedType $type */
        foreach ($types as $type) {
            if (VerifyDto::isDto($type->getName())) {
                return true;
            }
        }

        return false;
    }

    /**
     * @template T as object
     *
     * @param class-string<T> $className
     *
     * @return T|null
     */
    public function getAttributeInstance(string $className): ?object
    {
        $attributes = $this->property->getAttributes($className);

        if (empty($attributes)) {
            return null;
        }

        return $attributes[0]->newInstance();
    }

    /**
     * @return ReflectionNamedType[]
     */
    public function getTypes(): array
    {
        return $this->extractTypes();
    }

    private function resolveMappedName(): string|int
    {
        $attribute = $this->getAttributeInstance(MapFrom::class);

        if ($attribute === null) {
            return $this->property->getName();
        }

        return $attribute->getName();
    }

    private function extractTypes(): array
    {
        $reflectionTypes = $this->property->getType();

        return match ($reflectionTypes::class) {
            ReflectionNamedType::class => [$reflectionTypes],
            ReflectionUnionType::class => $reflectionTypes->getTypes()
        };
    }

    /**
     * @throws DtoException
     */
    private function guard(): void
    {
        if ($this->property->getType() === null) {
            $message = sprintf(
                'Field type "%s" was not specified.',
                $this->property->getName(),
            );
            throw new DtoException($message);
        }
    }
}
