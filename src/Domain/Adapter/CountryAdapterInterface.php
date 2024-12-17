<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\Adapter;

use EmpireDesAmis\BottleInventory\Domain\ValueObject\CountryName;

interface CountryAdapterInterface
{
    public function exist(CountryName $name): bool;
}
