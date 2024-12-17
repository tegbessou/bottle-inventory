<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\Event;

use Symfony\Contracts\EventDispatcher\Event;
use TegCorp\SharedKernelBundle\Domain\Event\DomainEventInterface;

final class GrapeVarietyCreated extends Event implements DomainEventInterface
{
    public function __construct(
        public string $grapeVarietyId,
    ) {
    }
}
