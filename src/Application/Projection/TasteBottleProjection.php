<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Projection;

use EmpireDesAmis\BottleInventory\Application\Exception\BottleDoesntExistException;
use EmpireDesAmis\BottleInventory\Application\Projection\Projector\TasteBottleProjector;
use EmpireDesAmis\BottleInventory\Domain\Event\BottleTasted;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;

#[WithMonologChannel('bottle_inventory')]
final readonly class TasteBottleProjection
{
    public function __construct(
        private TasteBottleProjector $tasteBottleProjector,
        private LoggerInterface $logger,
    ) {
    }

    public function __invoke(BottleTasted $event): void
    {
        try {
            $this->tasteBottleProjector->project(
                $event->bottleId,
                $event->tastedAt,
            );
        } catch (BottleDoesntExistException $exception) {
            $this->logger->error(
                'Taste bottle projection: Bottle projection update failed',
                [
                    'exception' => $exception->getMessage(),
                ],
            );

            throw $exception;
        }
    }
}
