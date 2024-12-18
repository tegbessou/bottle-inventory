<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\ValueObject;

use TegCorp\SharedKernelBundle\Infrastructure\Webmozart\Assert;

final readonly class BottleGrapeVarieties
{
    private array $values;

    public function __construct(
        array $values = [],
    ) {
        Assert::isArray($values);

        $this->values = $values;
    }

    public static function fromArray(
        array $values = [],
    ): self {
        return new self(
            $values,
        );
    }

    public function add(
        string $grapeVariety,
    ): self {
        return new self(
            array_merge(
                $this->values,
                [$grapeVariety]
            )
        );
    }

    public function values(): array
    {
        return $this->values;
    }
}
