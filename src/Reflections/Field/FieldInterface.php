<?php

namespace Dezer32\Libraries\Dto\Reflections\Field;

use Dezer32\Libraries\Dto\Contracts\DataTransferObjectInterface;

interface FieldInterface
{
    public function getName(): string|int;

    public function getValue(DataTransferObjectInterface $object): mixed;

    public function setValue(DataTransferObjectInterface $object, mixed $value = null): void;

    public function getDefaultValue(): mixed;

    public function isDto(): bool;

    public function isList(): bool;

    public function getTypeName(): string;

    public function castValue(mixed $value): mixed;

    public function getAttributeInstance(string $className): ?object;
}
