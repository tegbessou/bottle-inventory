<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Projection\Projector;

use EmpireDesAmis\BottleInventory\Application\Adapter\BottleListAdapterInterface;
use EmpireDesAmis\BottleInventory\Application\Exception\BottleDoesntExistException;

final readonly class DeleteBottleListProjector
{
    public function __construct(
        private BottleListAdapterInterface $bottleListAdapter,
    ) {
    }

    public function project(string $bottleId): void
    {
        $bottleList = $this->bottleListAdapter->ofId($bottleId);

        if ($bottleList === null) {
            throw new BottleDoesntExistException($bottleId);
        }

        $this->bottleListAdapter->delete($bottleList);
    }
}
