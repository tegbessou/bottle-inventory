<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Projection\Projector;

use EmpireDesAmis\BottleInventory\Application\Adapter\BottleListAdapterInterface;
use EmpireDesAmis\BottleInventory\Application\Exception\BottleDoesntExistException;

final readonly class AddPictureBottleListProjector
{
    public function __construct(
        private BottleListAdapterInterface $bottleListAdapter,
    ) {
    }

    public function project(string $bottleId, string $picture): void
    {
        $bottleList = $this->bottleListAdapter->ofId($bottleId);

        if ($bottleList === null) {
            throw new BottleDoesntExistException($bottleId);
        }

        $bottleList->picture = $picture;

        $this->bottleListAdapter->update($bottleList);
    }
}
