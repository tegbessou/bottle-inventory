<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Command;

use EmpireDesAmis\BottleInventory\Domain\Exception\BottleDoesntExistException;
use EmpireDesAmis\BottleInventory\Domain\Exception\DeleteBottleNotAuthorizeForThisUserException;
use EmpireDesAmis\BottleInventory\Domain\Repository\BottleRepositoryInterface;
use EmpireDesAmis\BottleInventory\Domain\Service\Authorization;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleId;
use TegCorp\SharedKernelBundle\Application\Command\AsCommandHandler;
use TegCorp\SharedKernelBundle\Domain\Service\DomainEventDispatcherInterface;

#[AsCommandHandler]
final readonly class DeleteBottleCommandHandler
{
    public function __construct(
        private BottleRepositoryInterface $bottleRepository,
        private DomainEventDispatcherInterface $eventDispatcher,
        private Authorization $authorizationService,
    ) {
    }

    public function __invoke(DeleteBottleCommand $deleteBottleCommand): void
    {
        $bottle = $this->bottleRepository->ofId(
            new BottleId($deleteBottleCommand->id)
        );

        if ($bottle === null) {
            throw new BottleDoesntExistException($deleteBottleCommand->id);
        }

        if (
            $this->authorizationService->isCurrentUserOwnerOfTheBottle($bottle) === false
        ) {
            throw new DeleteBottleNotAuthorizeForThisUserException();
        }

        $bottle->delete();

        $this->bottleRepository->delete($bottle);

        $this->eventDispatcher->dispatch($bottle);
    }
}
