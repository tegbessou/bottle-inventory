<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\ValueObject;

use EmpireDesAmis\BottleInventory\Domain\Enum\WineType;

final readonly class BottleWineType
{
    public function __construct(
        private WineType $value,
    ) {
    }

    public static function fromString(string $value): self
    {
        return new self(WineType::from($value));
    }

    public function value(): string
    {
        return $this->value->value;
    }
}
