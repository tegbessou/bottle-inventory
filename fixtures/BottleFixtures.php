<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use EmpireDesAmis\BottleInventory\Domain\Enum\Rate;
use EmpireDesAmis\BottleInventory\Domain\Enum\WineType;
use EmpireDesAmis\BottleInventory\Infrastructure\Doctrine\Entity\Bottle;

final class BottleFixtures extends Fixture
{
    #[\Override]
    public function load(ObjectManager $manager): void
    {
        $bottles = [];

        $bottles[] = new Bottle(
            '7bd55df3-e53c-410b-83a4-8e5ed9bcd50d',
            'Château Margaux',
            'Château Margaux',
            WineType::RedWine,
            2015,
            ['Cabernet Sauvignon', 'Merlot', 'Cabernet Franc', 'Petit Verdot'],
            Rate::PLUS_PLUS,
            'hugues.gobet@gmail.com',
            new \DateTimeImmutable(),
            'France',
            1099.99,
            null,
            'chateau-margaux.jpg',
        );

        $bottles[] = new Bottle(
            '3a28deee-f221-4aa1-800b-6b5b27137bfc',
            'Domaine de la Romanée-Conti',
            'Domaine de la Romanée-Conti',
            WineType::RedWine,
            2010,
            ['Pinot Noir'],
            Rate::PLUS,
            'hugues.gobet@gmail.com',
            new \DateTimeImmutable(),
            'France',
            2999.99,
            null,
            'romanee-conti.jpg',
        );

        $bottles[] = new Bottle(
            '29523184-face-4e1c-8582-1637cd501cee',
            'Château Latour',
            'Château Latour',
            WineType::RedWine,
            2010,
            ['Cabernet Sauvignon', 'Merlot'],
            Rate::PLUS_PLUS,
            'hugues.gobet@gmail.com',
            new \DateTimeImmutable(),
            'France',
            999.99,
            null,
            'chateau-latour.jpg',
        );

        $bottles[] = new Bottle(
            'f077aa04-c3a4-4f1a-8c60-050b76bae7b7',
            'Opus One',
            'Opus One',
            WineType::RedWine,
            2015,
            ['Cabernet Sauvignon', 'Merlot'],
            Rate::MINUS_MINUS,
            'hugues.gobet@gmail.com',
            new \DateTimeImmutable(),
            'États-Unis',
            1299.99,
            null,
            'opus-one.jpg',
        );

        $bottles[] = new Bottle(
            '4eb449d9-7d23-4984-a68d-77aa19fccc60',
            'Sassicaia',
            'Tenuta San Guido',
            WineType::RedWine,
            2012,
            ['Cabernet Sauvignon', 'Cabernet Franc'],
            Rate::SPLENDID,
            'hugues.gobet@gmail.com',
            new \DateTimeImmutable(),
            'Italie',
            899.99,
            null,
            'tenuta-san-guido.webp',
        );

        $bottles[] = new Bottle(
            '5ec0917b-179f-46e4-87d6-db76fbddf45f',
            'Domaine Leflaive Montrachet Grand Cru',
            'Domaine Leflaive',
            WineType::WhiteWine,
            2016,
            ['Chardonnay'],
            Rate::PLUS_PLUS,
            'hugues.gobet@gmail.com',
            new \DateTimeImmutable(),
            'France',
            1599.99,
            null,
            'montrachet.png',
        );

        $bottles[] = new Bottle(
            '690a8473-82af-4e57-92cd-9186b12a024a',
            'Penfolds Grange',
            'Penfolds',
            WineType::RedWine,
            2008,
            ['Shiraz', 'Cabernet Sauvignon'],
            Rate::EQUAL,
            'hugues.gobet@gmail.com',
            new \DateTimeImmutable(),
            'Australie',
            1799.99,
            null,
            'penfolds.webp',
        );

        $bottles[] = new Bottle(
            '1c0bab10-f5e5-42dd-9748-baeb5be15050',
            'Caymus Vineyards Special Selection Cabernet Sauvignon',
            'Caymus Vineyards',
            WineType::RedWine,
            2013,
            ['Cabernet Sauvignon'],
            Rate::PLUS_PLUS,
            'hugues.gobet@gmail.com',
            new \DateTimeImmutable(),
            'États-Unis',
            259.99,
            null,
            'caymus.jpg',
        );

        $bottles[] = new Bottle(
            'ea1708c2-a1d9-495e-80dc-93b0b61757ed',
            'Vega Sicilia Único',
            'Vega Sicilia',
            WineType::RedWine,
            2011,
            ['Tempranillo', 'Cabernet Sauvignon'],
            Rate::MINUS_MINUS,
            'hugues.gobet@gmail.com',
            new \DateTimeImmutable(),
            'Espagne',
            1499.99,
            null,
            'vega-sicilia.webp',
        );

        $bottles[] = new Bottle(
            'b54cafe9-436e-47a4-9456-61117f6a1648',
            'Cloudy Bay Sauvignon Blanc',
            'Cloudy Bay',
            WineType::WhiteWine,
            2019,
            ['Sauvignon Blanc'],
            Rate::MINUS,
            'hugues.gobet@gmail.com',
            new \DateTimeImmutable(),
            'New Zealand',
            49.99,
            null,
            'cloudy-bay.png',
        );

        $bottles[] = new Bottle(
            'e7f247a6-661c-4640-8ac8-25ee1e3eeb6d',
            'Gaja Barbaresco',
            'Gaja',
            WineType::RedWine,
            2016,
            ['Nebbiolo'],
            Rate::SPLENDID,
            'hugues.gobet@gmail.com',
            new \DateTimeImmutable(),
            'Italy',
            899.99,
            null,
            'gaja.jpg',
        );

        $bottles[] = new Bottle(
            '97102d4c-da46-4105-8c34-53f5a2e1e9fa',
            'Ridge Monte Bello',
            'Ridge Vineyards',
            WineType::RedWine,
            2014,
            ['Cabernet Sauvignon', 'Merlot'],
            Rate::EQUAL,
            'root@gmail.com',
            new \DateTimeImmutable(),
            'United States',
            199.99,
            null,
            'ridge-vineyards.png',
        );

        $bottles[] = new Bottle(
            '635e809c-aaaf-40df-8483-83cfbe2c5504',
            'Guigal Côte-Rôtie',
            'E. Guigal',
            WineType::RedWine,
            2014,
            ['Syrah', 'Viognier'],
            Rate::PLUS_PLUS,
            'hugues.gobet@gmail.com',
            new \DateTimeImmutable(),
            'France',
            358.99,
        );

        foreach ($bottles as $bottle) {
            $manager->persist($bottle);
        }

        $manager->flush();
    }
}
