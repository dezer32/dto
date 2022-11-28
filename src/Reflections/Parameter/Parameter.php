<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Reflections\Parameter;

use Dezer32\Libraries\Dto\Contracts\DataTransferObjectInterface;
use Dezer32\Libraries\Dto\Exceptions\DtoException;
use Dezer32\Libraries\Dto\Reflections\DtoClass\DtoClassInterface;
use ReflectionParameter;

class Parameter implements ParameterInterface
{
    private DtoClassInterface $declaringClass;

    /**
     * @throws DtoException
     */
    public function __construct(
        private ReflectionParameter $reflectionParameter,
    ) {
        $this->guard();
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
