<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto;

use Dezer32\Libraries\Dto\Contracts\ArrayTransformerInterface;
use Dezer32\Libraries\Dto\Reflections\DtoClass\DtoClass;

class ArrayTransformer implements ArrayTransformerInterface
{
    private DtoClass $class;

    public function __construct(
        private mixed $object
    ) {
        $this->class = new DtoClass(get_class($this->object));
    }

    public static function transform(mixed $object): array
    {
        return (new self($object))->toArray();
    }

    private function toArray(): array
    {
        $data = [];
        foreach ($this->class->getProperties() as $property) {
            $value = $property->getValue($this->object);
            if ($property->isDto()) {
                $value = $value->toArray();
            }
            if ($property->isList()) {
                $value = $this->list2array($value);
            }
            $data[$property->getName()] = $value;
        }

        return $data;
    }

    private function list2array(array $list): array
    {
        $data = [];
        foreach ($list as $item) {
            $data[] = ArrayTransformer::transform($item);
        }

        return $data;
    }
}
