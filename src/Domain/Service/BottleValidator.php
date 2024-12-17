<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\Service;

use EmpireDesAmis\BottleInventory\Domain\Adapter\CountryAdapterInterface;
use EmpireDesAmis\BottleInventory\Domain\Exception\BottleCountryDoesntExistException;
use EmpireDesAmis\BottleInventory\Domain\Exception\BottleGrapeVarietiesDoesntExistException;
use EmpireDesAmis\BottleInventory\Domain\Repository\GrapeVarietyRepositoryInterface;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\CountryName;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\GrapeVarietyName;

final readonly class BottleValidator
{
    public function __construct(
        private CountryAdapterInterface $countryReadRepository,
        private GrapeVarietyRepositoryInterface $grapeVarietyReadRepository,
    ) {
    }

    public function validate(
        ?string $country,
        array $grapeVarieties = [],
    ): void {
        $this->validateThatCountryExists($country);
        $this->validateThatGrapeVarietiesExist($grapeVarieties);
    }

    private function validateThatCountryExists(?string $country): void
    {
        if ($country === null) {
            return;
        }

        if ($this->countryReadRepository->exist(CountryName::fromString($country))) {
            return;
        }

        throw new BottleCountryDoesntExistException($country);
    }

    private function validateThatGrapeVarietiesExist(array $grapeVarieties): void
    {
        if (count($grapeVarieties) === 0) {
            return;
        }

        $grapeVarietiesDoesntExist = [];

        foreach ($grapeVarieties as $grapeVariety) {
            if ($this->grapeVarietyReadRepository->exist(GrapeVarietyName::fromString($grapeVariety))) {
                continue;
            }

            $grapeVarietiesDoesntExist[] = $grapeVariety;
        }

        if (count($grapeVarietiesDoesntExist) === 0) {
            return;
        }

        throw new BottleGrapeVarietiesDoesntExistException($grapeVarietiesDoesntExist);
    }
}
