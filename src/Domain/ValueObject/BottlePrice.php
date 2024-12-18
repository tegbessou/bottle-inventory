<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\ValueObject;

use TegCorp\SharedKernelBundle\Infrastructure\Webmozart\Assert;

final readonly class BottlePrice
{
    private float $amount;

    public function __construct(
        float $amount,
    ) {
        Assert::positiveFloat($amount);

        $this->amount = $amount;
    }

    public static function fromFloat(
        float $amount,
    ): self {
        return new self($amount);
    }

    public function amount(): float
    {
        return $this->amount;
    }
}
