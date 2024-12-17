<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Command;

use EmpireDesAmis\BottleInventory\Domain\Entity\Bottle;
use EmpireDesAmis\BottleInventory\Domain\Repository\BottleRepositoryInterface;
use EmpireDesAmis\BottleInventory\Domain\Service\BottleValidator;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleCountry;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleEstateName;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleGrapeVarieties;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleId;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleName;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleOwnerId;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottlePrice;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleRate;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleWineType;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleYear;
use TegCorp\SharedKernelBundle\Application\Command\AsCommandHandler;
use TegCorp\SharedKernelBundle\Domain\Service\DomainEventDispatcherInterface;

#[AsCommandHandler]
final readonly class CreateBottleCommandHandler
{
    public function __construct(
        private DomainEventDispatcherInterface $dispatcher,
        private BottleValidator $validator,
        private BottleRepositoryInterface $bottleRepository,
    ) {
    }

    public function __invoke(CreateBottleCommand $createBottleCommand): BottleId
    {
        $this->validator->validate(
            $createBottleCommand->country,
            $createBottleCommand->grapeVarieties,
        );

        $bottle = Bottle::create(
            $this->bottleRepository->nextIdentity(),
            BottleName::fromString($createBottleCommand->name),
            BottleEstateName::fromString($createBottleCommand->estateName),
            BottleWineType::fromString($createBottleCommand->type),
            BottleYear::fromInt($createBottleCommand->year),
            BottleGrapeVarieties::fromArray($createBottleCommand->grapeVarieties),
            BottleRate::fromString($createBottleCommand->rate),
            BottleOwnerId::fromString($createBottleCommand->ownerId),
            $createBottleCommand->country !== null ? BottleCountry::fromString($createBottleCommand->country) : null,
            $createBottleCommand->price !== null ? BottlePrice::fromFloat($createBottleCommand->price) : null,
        );

        $this->bottleRepository->add($bottle);

        $this->dispatcher->dispatch($bottle);

        return $bottle->id();
    }
}
