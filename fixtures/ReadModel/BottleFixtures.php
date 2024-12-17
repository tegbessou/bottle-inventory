<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\DataFixtures\ReadModel;

use Doctrine\Bundle\MongoDBBundle\Fixture\Fixture;
use Doctrine\Persistence\ObjectManager;
use EmpireDesAmis\BottleInventory\Application\ReadModel\Bottle;

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
            '++',
            2015,
            'red',
            '2021-01-01',
            ['Cabernet Sauvignon', 'Merlot', 'Cabernet Franc', 'Petit Verdot'],
            'hugues.gobet@gmail.com',
            'Hoge Hoge',
            'France',
            1099.99,
            'chateau-margaux.jpg',
        );

        $bottles[] = new Bottle(
            '3a28deee-f221-4aa1-800b-6b5b27137bfc',
            'Domaine de la Romanée-Conti',
            'Domaine de la Romanée-Conti',
            '+',
            2010,
            'red',
            '2021-01-01',
            ['Pinot Noir'],
            'hugues.gobet@gmail.com',
            'Hoge Hoge',
            'France',
            2999.99,
            'romanee-conti.jpg',
        );

        $bottles[] = new Bottle(
            '29523184-face-4e1c-8582-1637cd501cee',
            'Château Latour',
            'Château Latour',
            '++',
            2010,
            'red',
            '2021-01-01',
            ['Cabernet Sauvignon', 'Merlot'],
            'hugues.gobet@gmail.com',
            'Hoge Hoge',
            'France',
            999.99,
            'chateau-latour.jpg',
        );

        $bottles[] = new Bottle(
            'f077aa04-c3a4-4f1a-8c60-050b76bae7b7',
            'Opus One',
            'Opus One',
            '--',
            2015,
            'red',
            '2021-01-01',
            ['Cabernet Sauvignon', 'Merlot'],
            'hugues.gobet@gmail.com',
            'Hoge Hoge',
            'États-Unis',
            1299.99,
            'opus-one.jpg',
        );

        $bottles[] = new Bottle(
            '4eb449d9-7d23-4984-a68d-77aa19fccc60',
            'Sassicaia',
            'Tenuta San Guido',
            'xs',
            2012,
            'red',
            '2021-01-01',
            ['Cabernet Sauvignon', 'Cabernet Franc'],
            'hugues.gobet@gmail.com',
            'Hoge Hoge',
            'Italie',
            899.99,
            'tenuta-san-guido.webp',
        );

        $bottles[] = new Bottle(
            '5ec0917b-179f-46e4-87d6-db76fbddf45f',
            'Domaine Leflaive Montrachet Grand Cru',
            'Domaine Leflaive',
            '++',
            2016,
            'white',
            '2021-01-01',
            ['Chardonnay'],
            'hugues.gobet@gmail.com',
            'Hoge Hoge',
            'France',
            1599.99,
            'montrachet.png',
        );

        $bottles[] = new Bottle(
            '690a8473-82af-4e57-92cd-9186b12a024a',
            'Penfolds Grange',
            'Penfolds',
            '=',
            2008,
            'red',
            '2021-01-01',
            ['Shiraz', 'Cabernet Sauvignon'],
            'hugues.gobet@gmail.com',
            'Hoge Hoge',
            'Australie',
            1799.99,
            'penfolds.webp',
        );

        $bottles[] = new Bottle(
            '1c0bab10-f5e5-42dd-9748-baeb5be15050',
            'Caymus Vineyards Special Selection Cabernet Sauvignon',
            'Caymus Vineyards',
            '++',
            2013,
            'red',
            '2021-01-01',
            ['Cabernet Sauvignon'],
            'hugues.gobet@gmail.com',
            'Hoge Hoge',
            'États-Unis',
            259.99,
            'caymus.jpg',
        );

        $bottles[] = new Bottle(
            'ea1708c2-a1d9-495e-80dc-93b0b61757ed',
            'Vega Sicilia Único',
            'Vega Sicilia',
            '--',
            2011,
            'red',
            '2021-01-01',
            ['Tempranillo', 'Cabernet Sauvignon'],
            'hugues.gobet@gmail.com',
            'Hoge Hoge',
            'Espagne',
            1499.99,
            'vega-sicilia.webp',
        );

        $bottles[] = new Bottle(
            'b54cafe9-436e-47a4-9456-61117f6a1648',
            'Cloudy Bay Sauvignon Blanc',
            'Cloudy Bay',
            '-',
            2019,
            'white',
            '2021-01-01',
            ['Sauvignon Blanc'],
            'hugues.gobet@gmail.com',
            'Hoge Hoge',
            'New Zealand',
            49.99,
            'cloudy-bay.png',
        );

        $bottles[] = new Bottle(
            'e7f247a6-661c-4640-8ac8-25ee1e3eeb6d',
            'Gaja Barbaresco',
            'Gaja',
            'xs',
            2016,
            'red',
            '2021-01-01',
            ['Nebbiolo'],
            'hugues.gobet@gmail.com',
            'Hoge Hoge',
            'Italy',
            899.99,
            'gaja.jpg',
        );

        $bottles[] = new Bottle(
            '97102d4c-da46-4105-8c34-53f5a2e1e9fa',
            'Ridge Monte Bello',
            'Ridge Vineyards',
            '=',
            2014,
            'red',
            '2021-01-01',
            ['Cabernet Sauvignon', 'Merlot'],
            'root@gmail.com',
            'Hoge Hoge',
            'United States',
            199.99,
            'ridge-vineyards.png',
        );

        $bottles[] = new Bottle(
            '635e809c-aaaf-40df-8483-83cfbe2c5504',
            'Guigal Côte-Rôtie',
            'E. Guigal',
            '++',
            2014,
            'red',
            '2021-01-01',
            ['Syrah', 'Viognier'],
            'hugues.gobet@gmail.com',
            'Hoge Hoge',
            'France',
            358.99,
        );

        foreach ($bottles as $bottle) {
            $manager->persist($bottle);
            $manager->flush();
        }
    }
}
