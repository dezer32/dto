<?php

namespace Dezer32\Libraries\Dto\Reflections\Parameter;

interface ParameterInterface
{
    public function isDataTransferObject(): bool;

    public function getName(): string;

    public function getTypeName(): string;

    public function getDefaultValue(): mixed;

    public function castValue(mixed $value): mixed;
}
