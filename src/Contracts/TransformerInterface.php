<?php

namespace Dezer32\Libraries\Dto\Contracts;

interface TransformerInterface
{
    /**
     * @template T as object
     *
     * @param class-string<T> $className
     *
     * @return T
     */
    public static function transform(string $className, array $args): object;
}
