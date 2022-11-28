<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto;

use Dezer32\Libraries\Dto\Contracts\ClassTransformerInterface;
use Dezer32\Libraries\Dto\Contracts\DataTransferObjectInterface;
use Dezer32\Libraries\Dto\Reflections\DtoClass\DtoClass;
use Dezer32\Libraries\Dto\Reflections\Parameter\ParameterInterface;

class ClassTransformer implements ClassTransformerInterface
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
            }

            $constructor[] = $parameter->castValue($value);
        }

        return $class->make($constructor);
    }

    private function isDataTransferObject(mixed $mixed): bool
    {
        return is_subclass_of($mixed, DataTransferObjectInterface::class);
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
