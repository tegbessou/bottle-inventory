<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Projection\Projector;

use EmpireDesAmis\BottleInventory\Application\Adapter\BottleAdapterInterface;
use EmpireDesAmis\BottleInventory\Application\Exception\BottleDoesntExistException;

final readonly class DeleteBottleProjector
{
    public function __construct(
        private BottleAdapterInterface $bottleAdapter,
    ) {
    }

    public function project(string $bottleId): void
    {
        $bottle = $this->bottleAdapter->ofId($bottleId);

        if ($bottle === null) {
            throw new BottleDoesntExistException($bottleId);
        }

        $this->bottleAdapter->delete($bottle);
    }
}
