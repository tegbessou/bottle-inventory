<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\ValueObject;

use TegCorp\SharedKernelBundle\Infrastructure\Webmozart\Assert;

final readonly class BottleOwnerId
{
    private string $value;

    public function __construct(
        string $value,
    ) {
        Assert::maxLength($value, 255);
        Assert::email($value);

        $this->value = $value;
    }

    public static function fromString(
        string $value,
    ): self {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}
