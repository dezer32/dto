<?php

namespace Dezer32\Libraries\Dto\Contracts;

interface ArrayTransformerInterface
{
    public static function transform(DataTransferObjectInterface $object): array;
}
