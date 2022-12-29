<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto;

use Dezer32\Libraries\Dto\Contracts\TransformerInterface;
use Dezer32\Libraries\Dto\Helpers\Arr;
use Dezer32\Libraries\Dto\Helpers\VerifyDto;
use Dezer32\Libraries\Dto\Reflections\DtoClass\DtoClass;

class Transformer implements TransformerInterface
{
    private function __construct(
        private string $className,
        private array $args,
    ) {
    }

    /**
     * @psalm-template T of object
     *
     * @param class-string<T> $className
     *
     * @return T
     */
    public static function transform(string $className, array $args): object
    {
        return (new static($className, $args))->toObject();
    }

    private function toObject(): object
    {
        $class = new DtoClass($this->className);

        $constructor = [];
        foreach ($class->getParameters() as $parameter) {
            $value = Arr::getValue($this->args, $parameter->getName(), $parameter->getDefaultValue());
            Arr::forget($this->args, $parameter->getName());

            if ($parameter->isDto() && !VerifyDto::isDto($value)) {
                $value = self::transform($parameter->getTypeName(), $value);
            } else {
                $value = $parameter->castValue($value);
            }

            $constructor[] = $value;
        }

        return $class->make($constructor);
    }
}
