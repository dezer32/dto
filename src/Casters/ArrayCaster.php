<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Casters;

use Dezer32\Libraries\Dto\Contracts\CasterInterface;
use Dezer32\Libraries\Dto\Transformer;

class ArrayCaster implements CasterInterface
{
    public function __construct(
        private string $className
    ) {
    }

    public function cast(mixed $value): array
    {
        if (is_a($value, $this->className)) {
            return $value;
        }

        if (!is_array($value)) {
            return [];
        }

        $data = [];
        foreach ($value as $item) {
            $data[] = Transformer::transform($this->className, $item);
        }

        return $data;
    }
}
