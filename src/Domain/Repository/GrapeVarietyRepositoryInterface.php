<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\Repository;

use EmpireDesAmis\BottleInventory\Domain\ValueObject\GrapeVarietyName;

interface GrapeVarietyRepositoryInterface
{
    public function exist(GrapeVarietyName $name): bool;
}
