<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Projection;

use EmpireDesAmis\BottleInventory\Application\Exception\BottleDoesntExistException;
use EmpireDesAmis\BottleInventory\Application\Exception\OwnerDoesntExistException;
use EmpireDesAmis\BottleInventory\Application\Projection\Projector\CreateBottleProjector;
use EmpireDesAmis\BottleInventory\Domain\Event\BottleCreated;
use Psr\Log\LoggerInterface;

final readonly class CreateBottleProjection
{
    public function __construct(
        private CreateBottleProjector $createBottleProjector,
        private LoggerInterface $logger,
    ) {
    }

    public function __invoke(BottleCreated $event): void
    {
        try {
            $this->createBottleProjector->project(
                $event->bottleId,
                $event->name,
                $event->estateName,
                $event->wineType,
                $event->year,
                $event->rate,
                $event->grapeVarieties,
                $event->savedAt,
                $event->ownerId,
                $event->country,
                $event->price,
            );
        } catch (BottleDoesntExistException $exception) {
            $this->logger->error(
                'Create bottle projection: Bottle projection creation failed',
                [
                    'exception' => $exception->getMessage(),
                ],
            );

            throw $exception;
        } catch (OwnerDoesntExistException $exception) {
            $this->logger->error(
                'Create bottle projection: Owner doesn\'t exist',
                [
                    'exception' => $exception->getMessage(),
                ],
            );

            throw $exception;
        }
    }
}
