<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\Entity;

use EmpireDesAmis\BottleInventory\Domain\Event\GrapeVarietyCreated;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\GrapeVarietyId;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\GrapeVarietyName;
use TegCorp\SharedKernelBundle\Domain\Entity\EntityDomainEventTrait;
use TegCorp\SharedKernelBundle\Domain\Entity\EntityWithDomainEventInterface;

final class GrapeVariety implements EntityWithDomainEventInterface
{
    use EntityDomainEventTrait;

    public function __construct(
        public GrapeVarietyId $id,
        public GrapeVarietyName $name,
    ) {
    }

    public static function create(
        GrapeVarietyId $id,
        GrapeVarietyName $name,
    ): self {
        $grapeVariety = new self(
            $id,
            $name,
        );

        $grapeVariety::recordEvent(
            new GrapeVarietyCreated(
                $grapeVariety->id->value(),
            )
        );

        return $grapeVariety;
    }

    public function id(): GrapeVarietyId
    {
        return $this->id;
    }

    public function name(): GrapeVarietyName
    {
        return $this->name;
    }
}
