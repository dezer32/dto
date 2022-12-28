<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Helpers;

class Arr
{
    public static function getValue(
        array $array,
        string | int $name,
        mixed $defaultValue = null
    ): mixed {
        return $array[$name] ?? $defaultValue;
    }

    public static function forget(
        array &$array,
        string | int $name
    ): void {
        unset($array[$name]);
    }
}
