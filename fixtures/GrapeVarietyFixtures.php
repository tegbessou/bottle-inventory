<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use EmpireDesAmis\BottleInventory\Infrastructure\Doctrine\Entity\GrapeVariety;

final class GrapeVarietyFixtures extends Fixture
{
    #[\Override]
    public function load(ObjectManager $manager): void
    {
        $grapeVarieties = [];

        $grapeVarieties[] = new GrapeVariety(
            '48963d6e-2ba1-4197-ae2b-51cef06e3468',
            'Cabernet Sauvignon',
        );

        $grapeVarieties[] = new GrapeVariety(
            '8a88c8a8-1d72-40dc-a293-5bbb2c0143b5',
            'Merlot',
        );

        $grapeVarieties[] = new GrapeVariety(
            'b72db327-2d88-413e-9836-48953b9331b6',
            'Cabernet Franc',
        );

        $grapeVarieties[] = new GrapeVariety(
            '19b06368-699e-43ad-a320-5aa5e30d8305',
            'Petit Verdot',
        );

        $grapeVarieties[] = new GrapeVariety(
            'af91d0e6-9cf4-46b1-ab68-ee444e18d78b',
            'Pinot Noir',
        );

        $grapeVarieties[] = new GrapeVariety(
            'a187c830-9465-4cd9-a53e-6f1292f9d209',
            'Chardonnay',
        );

        $grapeVarieties[] = new GrapeVariety(
            'ddb81d1a-e1ec-4451-8ae0-f089d2bc6a8e',
            'Shiraz',
        );

        $grapeVarieties[] = new GrapeVariety(
            '351c4459-0181-4924-8e99-df0340087680',
            'Tempranillo',
        );

        $grapeVarieties[] = new GrapeVariety(
            '8eb306fc-3751-440b-859e-39339fd03d0b',
            'Sauvignon Blanc',
        );

        $grapeVarieties[] = new GrapeVariety(
            '7733caf9-7117-4f0d-add2-e3190ce6410e',
            'Nebbiolo',
        );

        $grapeVarieties[] = new GrapeVariety(
            '4f723f60-a39a-48f5-bbed-0c162b607f0a',
            'Grenache',
        );

        $grapeVarieties[] = new GrapeVariety(
            '5decae3c-fd54-4acf-a8b9-e1088f09c528',
            'Cinsault',
        );

        $grapeVarieties[] = new GrapeVariety(
            '1dab5088-b0cc-4e75-b40f-7c3e94b1ecb7',
            'Syrah',
        );

        $grapeVarieties[] = new GrapeVariety(
            '7bbe9239-91e1-4be5-a9f0-27d867394f62',
            'Chenin',
        );

        foreach ($grapeVarieties as $grapeVariety) {
            $manager->persist($grapeVariety);
        }

        $manager->flush();
    }
}
