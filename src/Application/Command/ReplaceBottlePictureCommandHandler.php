<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Command;

use EmpireDesAmis\BottleInventory\Domain\Exception\ReplaceBottlePictureBottleDoesntExistException;
use EmpireDesAmis\BottleInventory\Domain\Exception\UpdateBottleNotAuthorizeForThisUserException;
use EmpireDesAmis\BottleInventory\Domain\Repository\BottleRepositoryInterface;
use EmpireDesAmis\BottleInventory\Domain\Service\Authorization;
use EmpireDesAmis\BottleInventory\Domain\Service\UploadBottlePictureInterface;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleId;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottlePicture;
use TegCorp\SharedKernelBundle\Application\Command\AsCommandHandler;
use TegCorp\SharedKernelBundle\Domain\Service\DomainEventDispatcherInterface;

#[AsCommandHandler]
final readonly class ReplaceBottlePictureCommandHandler
{
    public function __construct(
        private BottleRepositoryInterface $bottleRepository,
        private DomainEventDispatcherInterface $eventDispatcher,
        private UploadBottlePictureInterface $uploadBottlePicture,
        private Authorization $authorizationService,
    ) {
    }

    /**
     * @throws ReplaceBottlePictureBottleDoesntExistException
     */
    public function __invoke(
        ReplaceBottlePictureCommand $command,
    ): void {
        $bottle = $this->bottleRepository->ofId(
            BottleId::fromString($command->id),
        );

        if ($bottle === null) {
            throw new ReplaceBottlePictureBottleDoesntExistException();
        }

        if ($this->authorizationService->isCurrentUserOwnerOfTheBottle($bottle) === false) {
            throw new UpdateBottleNotAuthorizeForThisUserException();
        }

        $pictureName = $this->uploadBottlePicture->upload(
            $bottle,
            $command->picturePath,
            $command->pictureOriginalName,
        );

        $bottle->addPicture(
            BottlePicture::fromString($pictureName),
        );

        $this->bottleRepository->update($bottle);

        $this->eventDispatcher->dispatch($bottle);
    }
}
