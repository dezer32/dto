<?php

namespace Dezer32\Libraries\Dto\Reflections\Property;

use Dezer32\Libraries\Dto\Contracts\DataTransferObjectInterface;

interface PropertyInterface
{
    public function getName(): string;

    public function getValue(DataTransferObjectInterface $object): mixed;

    public function isDto(): bool;
}
