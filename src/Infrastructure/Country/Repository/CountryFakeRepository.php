<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\Country\Repository;

final readonly class CountryFakeRepository implements CountryRepositoryInterface
{
    #[\Override]
    public function ofName(string $name): array
    {
        if ($name === 'France') {
            return [
                [
                    'id' => 'a3951bea-ba9b-46e3-a3a7-74f5186f1020',
                    'name' => 'France',
                ],
            ];
        }

        return [];
    }
}
