<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\Event;

use TegCorp\SharedKernelBundle\Domain\Event\DomainEventInterface;

final readonly class BottleUpdated implements DomainEventInterface
{
    public function __construct(
        public string $bottleId,
        public string $name,
        public string $estateName,
        public string $wineType,
        public int $year,
        public array $grapeVarieties,
        public string $rate,
        public ?string $country = null,
        public ?float $price = null,
    ) {
    }
}
