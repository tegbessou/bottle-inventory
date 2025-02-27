<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\ValueObject;

use TegCorp\SharedKernelBundle\Infrastructure\Webmozart\Assert;

final readonly class BottleTastedAt
{
    private \DateTimeImmutable $date;

    public function __construct(
        \DateTimeImmutable $date,
    ) {
        Assert::dateNotInferiorThanToday($date);

        $this->date = $date;
    }

    public static function create(
        \DateTimeImmutable $date,
    ): self {
        return new self(
            $date,
        );
    }

    public function value(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function dateUs(): string
    {
        return $this->date->format('Y-m-d');
    }

    public function dateFr(): string
    {
        return $this->date->format('d-m-Y');
    }
}
