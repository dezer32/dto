<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS, Attribute::IS_REPEATABLE)]
class DataTransferObject
{
}
