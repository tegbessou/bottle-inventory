<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\ValueObject;

use EmpireDesAmis\BottleInventory\Domain\Enum\Rate;

final readonly class BottleRate
{
    public function __construct(
        private Rate $value,
    ) {
    }

    public static function fromString(
        string $value,
    ): self {
        return new self(Rate::from($value));
    }

    public function value(): string
    {
        return $this->value->value;
    }
}
