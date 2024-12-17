<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Projection\Projector;

use EmpireDesAmis\BottleInventory\Application\Adapter\BottleListAdapterInterface;
use EmpireDesAmis\BottleInventory\Application\Exception\BottleDoesntExistException;
use EmpireDesAmis\BottleInventory\Application\ReadModel\BottleList;
use EmpireDesAmis\BottleInventory\Domain\Repository\BottleRepositoryInterface;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleId;

final readonly class CreateBottleListProjector
{
    public function __construct(
        private BottleRepositoryInterface $bottleRepository,
        private BottleListAdapterInterface $bottleListAdapter,
    ) {
    }

    public function project(
        string $bottleId,
        string $name,
        string $estateName,
        string $wineType,
        int $year,
        string $rate,
        string $savedAt,
        string $ownerId,
    ): void {
        $bottle = $this->bottleRepository->ofId(
            BottleId::fromString(
                $bottleId,
            ),
        );

        if ($bottle === null) {
            throw new BottleDoesntExistException($bottleId);
        }

        $bottle = new BottleList(
            $bottleId,
            $name,
            $estateName,
            $rate,
            $year,
            $wineType,
            $savedAt,
            $ownerId,
        );

        $this->bottleListAdapter->add($bottle);
    }
}
