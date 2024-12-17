<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Projection\Projector;

use EmpireDesAmis\BottleInventory\Application\Adapter\BottleAdapterInterface;
use EmpireDesAmis\BottleInventory\Application\Exception\BottleDoesntExistException;

final readonly class UpdateBottleProjector
{
    public function __construct(
        private BottleAdapterInterface $bottleAdapter,
    ) {
    }

    public function project(
        string $bottleId,
        string $name,
        string $estateName,
        string $wineType,
        int $year,
        array $grapeVarieties,
        string $rate,
        ?string $country = null,
        ?float $price = null,
    ): void {
        $bottle = $this->bottleAdapter->ofId($bottleId);

        if ($bottle === null) {
            throw new BottleDoesntExistException($bottleId);
        }

        $bottle->name = $name;
        $bottle->estateName = $estateName;
        $bottle->wineType = $wineType;
        $bottle->year = $year;
        $bottle->grapeVarieties = $grapeVarieties;
        $bottle->rate = $rate;
        $bottle->country = $country;
        $bottle->price = $price;

        $this->bottleAdapter->update($bottle);
    }
}
