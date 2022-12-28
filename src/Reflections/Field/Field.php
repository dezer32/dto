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
    protected string | int $name;
    protected ReflectionProperty | ReflectionParameter $property;

    public function __construct(
        ReflectionProperty | ReflectionParameter $property
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

    public function getName(): string | int
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
        $attributes = $this->property->getAttributes(Cast::class);
        if (empty($attributes)) {
            return false;
        }

        /** @var Cast $attribute */
        $attribute = $attributes[0]->newInstance();

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

    private function resolveMappedName(): string | int
    {
        $attributes = $this->property->getAttributes(MapFrom::class);

        if (empty($attributes)) {
            return $this->property->getName();
        }

        return $attributes[0]->newInstance()->getName();
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
