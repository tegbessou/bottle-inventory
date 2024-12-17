<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use TegCorp\SharedKernelBundle\Infrastructure\Webmozart\Assert;

#[ORM\Embeddable]
final readonly class BottleTastedAt
{
    #[ORM\Column(name: 'tasted_at', type: 'date_immutable', nullable: true)]
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

    public function dateUs(): string
    {
        return $this->date->format('Y-m-d');
    }

    public function dateFr(): string
    {
        return $this->date->format('d-m-Y');
    }
}
