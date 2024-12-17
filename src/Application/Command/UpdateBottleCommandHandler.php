<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Command;

use EmpireDesAmis\BottleInventory\Domain\Exception\UpdateBottleDoesntExistException;
use EmpireDesAmis\BottleInventory\Domain\Exception\UpdateBottleNotAuthorizeForThisUserException;
use EmpireDesAmis\BottleInventory\Domain\Repository\BottleRepositoryInterface;
use EmpireDesAmis\BottleInventory\Domain\Service\Authorization;
use EmpireDesAmis\BottleInventory\Domain\Service\BottleValidator;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleCountry;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleEstateName;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleGrapeVarieties;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleId;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleName;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottlePrice;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleRate;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleWineType;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleYear;
use TegCorp\SharedKernelBundle\Application\Command\AsCommandHandler;
use TegCorp\SharedKernelBundle\Domain\Service\DomainEventDispatcherInterface;

#[AsCommandHandler]
final readonly class UpdateBottleCommandHandler
{
    public function __construct(
        private BottleRepositoryInterface $bottleRepository,
        private DomainEventDispatcherInterface $eventDispatcher,
        private BottleValidator $bottleValidator,
        private Authorization $authorizationService,
    ) {
    }

    public function __invoke(
        UpdateBottleCommand $command,
    ): void {
        $this->bottleValidator->validate(
            $command->country,
            $command->grapeVarieties,
        );

        $bottle = $this->bottleRepository->ofId(
            BottleId::fromString($command->bottleId),
        );

        if ($bottle === null) {
            throw new UpdateBottleDoesntExistException($command->bottleId);
        }

        if (
            $this->authorizationService->isCurrentUserOwnerOfTheBottle($bottle) === false
        ) {
            throw new UpdateBottleNotAuthorizeForThisUserException();
        }

        $bottle->update(
            BottleName::fromString($command->name),
            BottleEstateName::fromString($command->estateName),
            BottleWineType::fromString($command->type),
            BottleYear::fromInt($command->year),
            BottleGrapeVarieties::fromArray($command->grapeVarieties),
            BottleRate::fromString($command->rate),
            $command->country !== null ? BottleCountry::fromString($command->country) : null,
            $command->price !== null ? BottlePrice::fromFloat($command->price) : null
        );

        $this->bottleRepository->update($bottle);

        $this->eventDispatcher->dispatch($bottle);
    }
}
