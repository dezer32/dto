<?php

namespace Dezer32\Libraries\Dto\Reflections\Parameter;

interface ParameterInterface
{
    public function isDataTransferObject(): bool;

    public function getName(): string | int;

    public function getTypeName(): string;

    public function hasDefaultValue(): bool;

    public function getDefaultValue(): mixed;

    public function castValue(mixed $value): mixed;
}
