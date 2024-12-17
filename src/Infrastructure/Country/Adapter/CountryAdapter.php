<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\Country\Adapter;

use EmpireDesAmis\BottleInventory\Domain\Adapter\CountryAdapterInterface;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\CountryName;
use EmpireDesAmis\BottleInventory\Infrastructure\Country\Repository\CountryRepositoryInterface;

final readonly class CountryAdapter implements CountryAdapterInterface
{
    public function __construct(
        private CountryRepositoryInterface $countryRepository,
    ) {
    }

    #[\Override]
    public function exist(CountryName $name): bool
    {
        return count($this->countryRepository->ofName($name->value())) === 1;
    }
}
