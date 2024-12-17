<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\ValueObject;

use TegCorp\SharedKernelBundle\Infrastructure\Webmozart\Assert;

final readonly class UserName
{
    private string $value;

    public function __construct(
        string $value,
    ) {
        Assert::string($value);
        Assert::maxLength($value, 255);

        $this->value = $value;
    }

    public static function fromString(
        string $name,
    ): self {
        return new self($name);
    }

    public function value(): string
    {
        return $this->value;
    }
}
