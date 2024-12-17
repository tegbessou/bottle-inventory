<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\Event;

use TegCorp\SharedKernelBundle\Domain\Event\DomainEventInterface;

final class BottlePictureAdded implements DomainEventInterface
{
    public function __construct(
        public string $bottleId,
        public string $picture,
    ) {
    }
}
