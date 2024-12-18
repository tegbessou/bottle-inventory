<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\Event;

use TegCorp\SharedKernelBundle\Domain\Event\DomainEvent;
use TegCorp\SharedKernelBundle\Domain\Event\DomainEventInterface;

final class BottlePictureAdded extends DomainEvent implements DomainEventInterface
{
    public function __construct(
        public string $bottleId,
        public string $picture,
    ) {
        parent::__construct();
    }
}
