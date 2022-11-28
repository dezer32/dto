<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Reflections\Parameter;

use Dezer32\Libraries\Dto\Attributes\Cast;
use Dezer32\Libraries\Dto\Contracts\CasterInterface;
use Dezer32\Libraries\Dto\Contracts\DataTransferObjectInterface;
use Dezer32\Libraries\Dto\Exceptions\DtoException;
use ReflectionParameter;

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
        return is_subclass_of($this->getTypeName(), DataTransferObjectInterface::class);
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
            return null;
        }

        return $attributes[0]->newInstance();
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
