<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Query;

use EmpireDesAmis\BottleInventory\Application\Adapter\BottleListAdapterInterface;
use TegCorp\SharedKernelBundle\Application\Query\QueryInterface;

/**
 * @implements QueryInterface<BottleListAdapterInterface>
 */
final class GetBottlesQuery implements QueryInterface
{
    public function __construct(
        public ?string $name,
        public ?string $estateName,
        public ?string $type,
        public ?string $savedAt,
        public ?int $year,
        public ?string $rate,
        public ?int $page,
        public ?int $limit,
    ) {
    }
}
