<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\ValueObject;

use TegCorp\SharedKernelBundle\Infrastructure\Webmozart\Assert;

final readonly class BottleYear
{
    private int $value;

    public function __construct(
        int $value,
    ) {
        Assert::year($value);

        $this->value = $value;
    }

    public static function fromInt(
        int $value,
    ): self {
        return new self($value);
    }

    public function value(): int
    {
        return $this->value;
    }
}
