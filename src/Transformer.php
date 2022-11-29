<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto;

use Dezer32\Libraries\Dto\Attributes\DataTransferObject as DataTransferObjectAttribute;
use Dezer32\Libraries\Dto\Contracts\TransformerInterface;
use Dezer32\Libraries\Dto\Contracts\DataTransferObjectInterface;
use Dezer32\Libraries\Dto\Reflections\DtoClass\DtoClass;
use Dezer32\Libraries\Dto\Reflections\Parameter\ParameterInterface;

class Transformer implements TransformerInterface
{
    private function __construct(
        private string $className,
        private array $args,
    ) {
    }

    public static function transform(string $className, array $args): object
    {
        return (new static($className, $args))->toObject();
    }

    private function toObject(): object
    {
        $class = new DtoClass($this->className);

        $constructor = [];
        foreach ($class->getParameters() as $parameter) {
            $value = $this->getValue($parameter);

            if ($parameter->isDataTransferObject() && !$this->isDataTransferObject($value)) {
                $value = self::transform($parameter->getTypeName(), $value);
            } else {
                $value = $parameter->castValue($value);
            }

            $constructor[] = $value;
        }

        return $class->make($constructor);
    }

    private function isDataTransferObject(mixed $value): bool
    {
        return is_subclass_of($value, DataTransferObjectInterface::class)
            || $this->isAttributedDataTransferObject($value);
    }

    private function isAttributedDataTransferObject(mixed $value): bool
    {
        if (!is_object($value)) {
            return false;
        }

        $reflectionClass = new \ReflectionClass($value);

        $attributes = $reflectionClass->getAttributes(DataTransferObjectAttribute::class);

        return !empty($attributes);
    }

    private function getValue(ParameterInterface $parameter): mixed
    {
        if (isset($this->args[$parameter->getName()])) {
            $value = $this->args[$parameter->getName()];
            unset($this->args[$parameter->getName()]);
        } else {
            $value = $parameter->getDefaultValue();
        }

        return $value;
    }
}
