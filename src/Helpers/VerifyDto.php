<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Helpers;

use Dezer32\Libraries\Dto\Attributes\DataTransferObject as DataTransferObjectAttribute;
use Dezer32\Libraries\Dto\Contracts\DataTransferObjectInterface;
use ReflectionClass;

class VerifyDto
{
    public static function isDto(mixed $object): bool
    {
        if (!is_object($object) && !(is_string($object) && class_exists($object))) {
            return false;
        }

        return is_subclass_of($object, DataTransferObjectInterface::class) || self::isAttributedDto($object);
    }

    private static function isAttributedDto(mixed $object): bool
    {
        $reflectionClass = new ReflectionClass($object);

        $attributes = $reflectionClass->getAttributes(DataTransferObjectAttribute::class);

        return !empty($attributes);
    }
}
