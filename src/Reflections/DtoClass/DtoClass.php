<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Reflections\DtoClass;

use Dezer32\Libraries\Dto\Attributes\DataTransferObject;
use Dezer32\Libraries\Dto\Contracts\DataTransferObjectInterface;
use Dezer32\Libraries\Dto\Exceptions\DtoException;
use Dezer32\Libraries\Dto\Reflections\Field\Parameter;
use Dezer32\Libraries\Dto\Reflections\Field\Property;
use ReflectionClass;
use ReflectionProperty;

class DtoClass implements DtoClassInterface
{
    private ReflectionClass $reflectionClass;
    /** @var Parameter[] */
    private array $parameters;
    /** @var Property[] */
    private array $properties;

    public function __construct(
        private string $className,
    ) {
        $this->guard();
    }

    public function make(array $args): object
    {
        return $this->getReflectionClass()->newInstanceArgs($args);
    }

    public function getParameters(): array
    {
        if (!isset($this->parameters)) {
            $reflectionParameters = $this->getReflectionClass()->getConstructor()?->getParameters();
            $this->parameters = [];
            foreach ($reflectionParameters as $parameter) {
                $this->parameters[] = new Parameter($parameter);
            }
        }

        return $this->parameters;
    }

    public function getProperties(): array
    {
        if (!isset($this->properties)) {
            $reflectionProperties = $this->getReflectionClass()->getProperties(ReflectionProperty::IS_PRIVATE);

            $this->properties = [];
            foreach ($reflectionProperties as $property) {
                if ($property->isStatic()) {
                    continue;
                }

                $this->properties[] = new Property($property);
            }
        }

        return $this->properties;
    }

    private function getReflectionClass(): ReflectionClass
    {
        return $this->reflectionClass ??= new ReflectionClass($this->className);
    }

    private function guard(): void
    {
        if (!class_exists($this->className)) {
            throw new DtoException(sprintf('Class "%s" not found.', $this->className));
        }

        if (!$this->isDataTransferObject()) {
            throw new DtoException(sprintf('Class "%s" is not DataTransferObject class.', $this->className));
        }

        if ($this->getReflectionClass()->getConstructor() === null) {
            throw new DtoException(sprintf('Class "%s" constructor does not exists.', $this->className));
        }
    }

    private function isDataTransferObject(): bool
    {
        return is_subclass_of($this->className, DataTransferObjectInterface::class)
            || $this->isAttributedDataTransferObject();
    }

    private function isAttributedDataTransferObject(): bool
    {
        $attributes = $this->getReflectionClass()->getAttributes(DataTransferObject::class);

        return !empty($attributes);
    }
}
