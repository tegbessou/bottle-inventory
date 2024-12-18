<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\Event;

use TegCorp\SharedKernelBundle\Domain\Event\DomainEvent;
use TegCorp\SharedKernelBundle\Domain\Event\DomainEventInterface;

final class GrapeVarietyCreated extends DomainEvent implements DomainEventInterface
{
    public function __construct(
        public string $grapeVarietyId,
    ) {
        parent::__construct();
    }
}
