<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Projection;

use EmpireDesAmis\BottleInventory\Application\Exception\BottleDoesntExistException;
use EmpireDesAmis\BottleInventory\Application\Projection\Projector\AddPictureBottleProjector;
use EmpireDesAmis\BottleInventory\Domain\Event\BottlePictureAdded;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;

#[WithMonologChannel('bottle_inventory')]
final readonly class AddPictureBottleProjection
{
    public function __construct(
        private AddPictureBottleProjector $addPictureBottleProjector,
        private LoggerInterface $logger,
    ) {
    }

    public function __invoke(BottlePictureAdded $event): void
    {
        try {
            $this->addPictureBottleProjector->project(
                $event->bottleId,
                $event->picture,
            );
        } catch (BottleDoesntExistException $exception) {
            $this->logger->error(
                'Add picture bottle projection: Bottle projection update failed',
                [
                    'exception' => $exception->getMessage(),
                ],
            );

            throw $exception;
        }
    }
}
