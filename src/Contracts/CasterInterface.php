<?php

namespace Dezer32\Libraries\Dto\Contracts;

interface CasterInterface
{
    public function cast(mixed $value): mixed;
}
