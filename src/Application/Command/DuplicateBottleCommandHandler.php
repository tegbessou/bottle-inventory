<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Command;

use EmpireDesAmis\BottleInventory\Domain\Exception\BottleDoesntExistException;
use EmpireDesAmis\BottleInventory\Domain\Repository\BottleRepositoryInterface;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleId;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleOwnerId;
use TegCorp\SharedKernelBundle\Application\Command\AsCommandHandler;
use TegCorp\SharedKernelBundle\Domain\Factory\IdFactory;
use TegCorp\SharedKernelBundle\Domain\Service\DomainEventDispatcherInterface;

#[AsCommandHandler]
final readonly class DuplicateBottleCommandHandler
{
    public function __construct(
        private DomainEventDispatcherInterface $dispatcher,
        private BottleRepositoryInterface $bottleRepository,
        private IdFactory $idFactory,
    ) {
    }

    public function __invoke(DuplicateBottleCommand $duplicateBottleCommand): void
    {
        $bottle = $this->bottleRepository->ofId(
            BottleId::fromString($duplicateBottleCommand->bottleId),
        );

        if ($bottle === null) {
            throw new BottleDoesntExistException($duplicateBottleCommand->bottleId);
        }

        $duplicateBottle = $bottle->duplicate(
            BottleId::fromString($this->idFactory->create()),
            BottleOwnerId::fromString($duplicateBottleCommand->newOwner),
        );

        $this->bottleRepository->add($duplicateBottle);

        $this->dispatcher->dispatch($duplicateBottle);
    }
}
