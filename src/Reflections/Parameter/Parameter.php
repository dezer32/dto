<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Reflections\Parameter;

use Dezer32\Libraries\Dto\Attributes\Cast;
use Dezer32\Libraries\Dto\Attributes\DataTransferObject;
use Dezer32\Libraries\Dto\Attributes\DefaultCast;
use Dezer32\Libraries\Dto\Contracts\CasterInterface;
use Dezer32\Libraries\Dto\Contracts\DataTransferObjectInterface;
use Dezer32\Libraries\Dto\Exceptions\DtoException;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionUnionType;

class Parameter implements ParameterInterface
{
    private ?CasterInterface $caster;

    /**
     * @throws DtoException
     */
    public function __construct(
        private ReflectionParameter $reflectionParameter,
    ) {
        $this->guard();
        $this->caster = $this->resolveCaster();
    }

    public function isDataTransferObject(): bool
    {
        $types = $this->extractTypes();
        /** @var ReflectionNamedType $type */
        foreach ($types as $type) {
            if (
                is_subclass_of($type->getName(), DataTransferObjectInterface::class)
                || $this->isAttributedDataTransferObject($type->getName())
            ) {
                return true;
            }
        }

        return false;
    }

    private function isAttributedDataTransferObject(string $className): bool
    {
        if (!class_exists($className)) {
            return false;
        }

        $reflectionClass = new ReflectionClass($className);

        $attributes = $reflectionClass->getAttributes(DataTransferObject::class);

        return !empty($attributes);
    }

    public function getName(): string
    {
        return $this->reflectionParameter->getName();
    }

    public function getTypeName(): string
    {
        return $this->reflectionParameter->getType()?->getName();
    }

    public function getDefaultValue(): mixed
    {
        return $this->reflectionParameter->getDefaultValue();
    }

    public function castValue(mixed $value): mixed
    {
        if ($this->caster !== null) {
            $value = $this->caster->cast($value);
        }

        return $value;
    }

    private function resolveCaster(): ?CasterInterface
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

    private function extractTypes(): array
    {
        $reflectionTypes = $this->reflectionParameter->getType();

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
        if ($this->reflectionParameter->getType() === null) {
            $message = sprintf(
                'Property type "%s" was not specified.',
                $this->reflectionParameter->getName(),
            );
            throw new DtoException($message);
        }
    }
}
