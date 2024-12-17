<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\DataFixtures\ReadModel;

use Doctrine\Bundle\MongoDBBundle\Fixture\Fixture;
use Doctrine\Persistence\ObjectManager;
use EmpireDesAmis\BottleInventory\Application\ReadModel\BottleList;

final class BottleListFixtures extends Fixture
{
    #[\Override]
    public function load(ObjectManager $manager): void
    {
        $bottles = [];

        $bottles[] = new BottleList(
            '7bd55df3-e53c-410b-83a4-8e5ed9bcd50d',
            'Château Margaux',
            'Château Margaux',
            '++',
            2015,
            'red',
            '2021-01-01',
            'hugues.gobet@gmail.com',
            'chateau-margaux.jpg',
        );

        $bottles[] = new BottleList(
            '3a28deee-f221-4aa1-800b-6b5b27137bfc',
            'Domaine de la Romanée-Conti',
            'Domaine de la Romanée-Conti',
            '+',
            2010,
            'red',
            '2021-01-01',
            'hugues.gobet@gmail.com',
            'romanee-conti.jpg',
        );

        $bottles[] = new BottleList(
            '29523184-face-4e1c-8582-1637cd501cee',
            'Château Latour',
            'Château Latour',
            '++',
            2010,
            'red',
            '2021-01-01',
            'hugues.gobet@gmail.com',
            'chateau-latour.jpg',
        );

        $bottles[] = new BottleList(
            'f077aa04-c3a4-4f1a-8c60-050b76bae7b7',
            'Opus One',
            'Opus One',
            '--',
            2015,
            'red',
            '2021-01-01',
            'hugues.gobet@gmail.com',
            'opus-one.jpg',
        );

        $bottles[] = new BottleList(
            '4eb449d9-7d23-4984-a68d-77aa19fccc60',
            'Sassicaia',
            'Tenuta San Guido',
            'xs',
            2012,
            'red',
            '2021-01-01',
            'hugues.gobet@gmail.com',
            'tenuta-san-guido.webp',
        );

        $bottles[] = new BottleList(
            '5ec0917b-179f-46e4-87d6-db76fbddf45f',
            'Domaine Leflaive Montrachet Grand Cru',
            'Domaine Leflaive',
            '++',
            2016,
            'white',
            '2021-01-01',
            'hugues.gobet@gmail.com',
            'montrachet.png',
        );

        $bottles[] = new BottleList(
            '690a8473-82af-4e57-92cd-9186b12a024a',
            'Penfolds Grange',
            'Penfolds',
            '=',
            2008,
            'red',
            '2021-01-01',
            'hugues.gobet@gmail.com',
            'penfolds.webp',
        );

        $bottles[] = new BottleList(
            '1c0bab10-f5e5-42dd-9748-baeb5be15050',
            'Caymus Vineyards Special Selection Cabernet Sauvignon',
            'Caymus Vineyards',
            '++',
            2013,
            'red',
            '2021-01-01',
            'hugues.gobet@gmail.com',
            'caymus.jpg',
        );

        $bottles[] = new BottleList(
            'ea1708c2-a1d9-495e-80dc-93b0b61757ed',
            'Vega Sicilia Único',
            'Vega Sicilia',
            '--',
            2011,
            'red',
            '2021-01-01',
            'hugues.gobet@gmail.com',
            'vega-sicilia.webp',
        );

        $bottles[] = new BottleList(
            'b54cafe9-436e-47a4-9456-61117f6a1648',
            'Cloudy Bay Sauvignon Blanc',
            'Cloudy Bay',
            '-',
            2019,
            'white',
            '2021-01-01',
            'hugues.gobet@gmail.com',
            'cloudy-bay.png',
        );

        $bottles[] = new BottleList(
            'e7f247a6-661c-4640-8ac8-25ee1e3eeb6d',
            'Gaja Barbaresco',
            'Gaja',
            'xs',
            2016,
            'red',
            '2021-01-01',
            'hugues.gobet@gmail.com',
            'gaja.jpg',
        );

        $bottles[] = new BottleList(
            '97102d4c-da46-4105-8c34-53f5a2e1e9fa',
            'Ridge Monte Bello',
            'Ridge Vineyards',
            '=',
            2014,
            'red',
            '2021-01-01',
            'root@gmail.com',
            'ridge-vineyards.png',
        );

        $bottles[] = new BottleList(
            '635e809c-aaaf-40df-8483-83cfbe2c5504',
            'Guigal Côte-Rôtie',
            'E. Guigal',
            '++',
            2014,
            'red',
            '2021-01-01',
            'hugues.gobet@gmail.com',
        );

        foreach ($bottles as $bottle) {
            $manager->persist($bottle);
            $manager->flush();
        }
    }
}
