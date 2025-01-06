<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\Repository;

use EmpireDesAmis\BottleInventory\Domain\Entity\Bottle;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleId;

interface BottleRepositoryInterface
{
    public function ofId(BottleId $bottleId): ?Bottle;

    public function add(Bottle $bottle): void;

    public function update(Bottle $bottle): void;

    public function delete(Bottle $bottle): void;
}
