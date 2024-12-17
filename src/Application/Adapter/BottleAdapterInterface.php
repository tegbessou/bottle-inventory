<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Adapter;

use EmpireDesAmis\BottleInventory\Application\ReadModel\Bottle;

interface BottleAdapterInterface
{
    public function ofId(string $id): ?Bottle;

    public function add(Bottle $bottle): void;

    public function update(Bottle $bottle): void;

    public function delete(Bottle $bottle): void;
}
