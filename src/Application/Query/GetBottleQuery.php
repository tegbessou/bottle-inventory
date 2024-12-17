<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Query;

use EmpireDesAmis\BottleInventory\Application\ReadModel\Bottle;
use TegCorp\SharedKernelBundle\Application\Query\QueryInterface;

/**
 * @implements QueryInterface<Bottle|null>
 */
final readonly class GetBottleQuery implements QueryInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
