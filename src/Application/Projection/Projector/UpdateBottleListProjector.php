<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Projection\Projector;

use EmpireDesAmis\BottleInventory\Application\Adapter\BottleListAdapterInterface;
use EmpireDesAmis\BottleInventory\Application\Exception\BottleDoesntExistException;

final readonly class UpdateBottleListProjector
{
    public function __construct(
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
    ): void {
        $bottleList = $this->bottleListAdapter->ofId($bottleId);

        if ($bottleList === null) {
            throw new BottleDoesntExistException($bottleId);
        }

        $bottleList->name = $name;
        $bottleList->estateName = $estateName;
        $bottleList->wineType = $wineType;
        $bottleList->year = $year;
        $bottleList->rate = $rate;

        $this->bottleListAdapter->update($bottleList);
    }
}
