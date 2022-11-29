# DataTransferObject for PHP

## Introduce

## Installation

### 1. Install package

```bash
composer require dezer32/dto
```

### 2. Profit!

## Usage

### Dto:

```php
<?php

declare(strict_types=1);

use Dezer32\Libraries\Dto\DataTransferObject;

class TestDto extends DataTransferObject
{
    public function __construct(
        private string $text,
    ) {
    }
    
    public function getText(): string
    {
        return $this->text;
    }
}
```

or

```php
<?php

declare(strict_types=1);

use Dezer32\Libraries\Dto\Attributes\DataTransferObject;

#[DataTransferObject]
class TestDto
{
    public function __construct(
        private string $text,
    ) {
    }
    
    public function getText(): string
    {
        return $this->text;
    }
}
```

### Code:

```php
<?php

declare(strict_types=1);

use Dezer32\Libraries\Dto\Transformer;

$parameters = [
    'text' => 'test'
];
$dto = Transformer::transform(TestDto::class, $parameters);
//or
$dto = new TestDto('test');


```

## Casting

### #[Cast()]

```php
<?php

declare(strict_types=1);

use Dezer32\Libraries\Dto\Contracts\CasterInterface;

class CasterClass implements CasterInterface
{
    public function cast(mixed $value): string
    {
        return 'New string and ' . $value;
    }
}
```

```php
<?php

declare(strict_types=1);

use Dezer32\Libraries\Dto\Attributes\Cast;

class TestDto
{
    public function __construct(
        #[Cast(CasterClass::class)]
        private string $text,
    ) {
    }

    public function getText(): string
    {
        return $this->text;
    }
}
```

### #[DefaultCast()]

### List of DTOs #[Cast(ArrayCast::class, ConcreteDto::class)]

```php
<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto;

use Dezer32\Libraries\Dto\Attributes\DataTransferObject;

#[DataTransferObject]
class SimpleDto
{
    public function __construct(
        private string $text
    ) {
    }

    public function getText(): string
    {
        return $this->text;
    }
}
```

```php
<?php

declare(strict_types=1);

namespace Dezer32\Libraries\Dto\Test\Unit\Fixtures\Dto;

use Dezer32\Libraries\Dto\Attributes\Cast;
use Dezer32\Libraries\Dto\Attributes\DataTransferObject;
use Dezer32\Libraries\Dto\Casters\ArrayCaster;

#[DataTransferObject]
class SimpleListDto
{
    public function __construct(
        #[Cast(ArrayCaster::class, SimpleDto::class)]
        private array $list
    ) {
    }

    /** @return SimpleDto[] */
    public function getList(): array
    {
        return $this->list;
    }
}
```
