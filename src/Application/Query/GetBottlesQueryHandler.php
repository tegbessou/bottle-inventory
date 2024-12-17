<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Query;

use EmpireDesAmis\BottleInventory\Application\Adapter\BottleListAdapterInterface;
use TegCorp\SharedKernelBundle\Application\Query\AsQueryHandler;

#[AsQueryHandler]
final readonly class GetBottlesQueryHandler
{
    public function __construct(
        private BottleListAdapterInterface $bottleListAdapter,
    ) {
    }

    public function __invoke(GetBottlesQuery $query): BottleListAdapterInterface
    {
        $bottleListAdapter = $this->bottleListAdapter;

        $bottleListAdapter = $bottleListAdapter->sortName();

        if ($query->name !== null) {
            $bottleListAdapter = $bottleListAdapter->withName($query->name);
        }

        if ($query->estateName !== null) {
            $bottleListAdapter = $bottleListAdapter->withEstateName($query->estateName);
        }

        if ($query->year !== null) {
            $bottleListAdapter = $bottleListAdapter->withYear($query->year);
        }

        if ($query->rate !== null) {
            $bottleListAdapter = $bottleListAdapter->withRate($query->rate);
        }

        if ($query->savedAt !== null) {
            $bottleListAdapter = $bottleListAdapter->savedAt($query->savedAt);
        }

        if ($query->type !== null) {
            $bottleListAdapter = $bottleListAdapter->withWineType($query->type);
        }

        if ($query->page !== null && $query->limit !== null) {
            $bottleListAdapter = $bottleListAdapter->withPagination($query->page, $query->limit);
        }

        return $bottleListAdapter;
    }
}
