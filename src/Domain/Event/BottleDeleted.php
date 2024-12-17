<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\Event;

use TegCorp\SharedKernelBundle\Domain\Event\DomainEventInterface;

final readonly class BottleDeleted implements DomainEventInterface
{
    public function __construct(
        public string $bottleId,
    ) {
    }
}
