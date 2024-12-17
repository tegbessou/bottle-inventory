<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Query;

use EmpireDesAmis\BottleInventory\Application\Adapter\BottleAdapterInterface;
use EmpireDesAmis\BottleInventory\Application\ReadModel\Bottle;
use TegCorp\SharedKernelBundle\Application\Query\AsQueryHandler;

#[AsQueryHandler]
final readonly class GetBottleQueryHandler
{
    public function __construct(
        private BottleAdapterInterface $bottleAdapter,
    ) {
    }

    public function __invoke(
        GetBottleQuery $query,
    ): ?Bottle {
        return $this->bottleAdapter->ofId($query->id);
    }
}
