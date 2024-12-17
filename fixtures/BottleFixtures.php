<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use EmpireDesAmis\BottleInventory\Domain\Entity\Bottle;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleCountry;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleEstateName;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleGrapeVarieties;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleId;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleName;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleOwnerId;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottlePicture;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottlePrice;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleRate;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleWineType;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleYear;

final class BottleFixtures extends Fixture
{
    #[\Override]
    public function load(ObjectManager $manager): void
    {
        $bottles = [];

        $bottles[] = Bottle::create(
            BottleId::fromString('7bd55df3-e53c-410b-83a4-8e5ed9bcd50d'),
            BottleName::fromString('Château Margaux'),
            BottleEstateName::fromString('Château Margaux'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2015),
            BottleGrapeVarieties::fromArray(['Cabernet Sauvignon', 'Merlot', 'Cabernet Franc', 'Petit Verdot']),
            BottleRate::fromString('++'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(1099.99),
        )->addPicture(BottlePicture::fromString('chateau-margaux.jpg'));

        $bottles[] = Bottle::create(
            BottleId::fromString('3a28deee-f221-4aa1-800b-6b5b27137bfc'),
            BottleName::fromString('Domaine de la Romanée-Conti'),
            BottleEstateName::fromString('Domaine de la Romanée-Conti'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2010),
            BottleGrapeVarieties::fromArray(['Pinot Noir']),
            BottleRate::fromString('+'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(2999.99),
        )->addPicture(BottlePicture::fromString('romanee-conti.jpg'));

        $bottles[] = Bottle::create(
            BottleId::fromString('29523184-face-4e1c-8582-1637cd501cee'),
            BottleName::fromString('Château Latour'),
            BottleEstateName::fromString('Château Latour'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2010),
            BottleGrapeVarieties::fromArray(['Cabernet Sauvignon', 'Merlot']),
            BottleRate::fromString('++'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(999.99),
        )->addPicture(BottlePicture::fromString('chateau-latour.jpg'));

        $bottles[] = Bottle::create(
            BottleId::fromString('f077aa04-c3a4-4f1a-8c60-050b76bae7b7'),
            BottleName::fromString('Opus One'),
            BottleEstateName::fromString('Opus One'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2015),
            BottleGrapeVarieties::fromArray(['Cabernet Sauvignon', 'Merlot']),
            BottleRate::fromString('--'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('États-Unis'),
            BottlePrice::fromFloat(1299.99),
        )->addPicture(BottlePicture::fromString('opus-one.jpg'));

        $bottles[] = Bottle::create(
            BottleId::fromString('4eb449d9-7d23-4984-a68d-77aa19fccc60'),
            BottleName::fromString('Sassicaia'),
            BottleEstateName::fromString('Tenuta San Guido'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2012),
            BottleGrapeVarieties::fromArray(['Cabernet Sauvignon', 'Cabernet Franc']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('Italie'),
            BottlePrice::fromFloat(899.99),
        )->addPicture(BottlePicture::fromString('tenuta-san-guido.webp'));

        $bottles[] = Bottle::create(
            BottleId::fromString('5ec0917b-179f-46e4-87d6-db76fbddf45f'),
            BottleName::fromString('Domaine Leflaive Montrachet Grand Cru'),
            BottleEstateName::fromString('Domaine Leflaive'),
            BottleWineType::fromString('white'),
            BottleYear::fromInt(2016),
            BottleGrapeVarieties::fromArray(['Chardonnay']),
            BottleRate::fromString('++'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(1599.99),
        )->addPicture(BottlePicture::fromString('montrachet.png'));

        $bottles[] = Bottle::create(
            BottleId::fromString('690a8473-82af-4e57-92cd-9186b12a024a'),
            BottleName::fromString('Penfolds Grange'),
            BottleEstateName::fromString('Penfolds'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2008),
            BottleGrapeVarieties::fromArray(['Shiraz', 'Cabernet Sauvignon']),
            BottleRate::fromString('='),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('Australie'),
            BottlePrice::fromFloat(1799.99),
        )->addPicture(BottlePicture::fromString('penfolds.webp'));

        $bottles[] = Bottle::create(
            BottleId::fromString('1c0bab10-f5e5-42dd-9748-baeb5be15050'),
            BottleName::fromString('Caymus Vineyards Special Selection Cabernet Sauvignon'),
            BottleEstateName::fromString('Caymus Vineyards'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2013),
            BottleGrapeVarieties::fromArray(['Cabernet Sauvignon']),
            BottleRate::fromString('++'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('États-Unis'),
            BottlePrice::fromFloat(259.99),
        )->addPicture(BottlePicture::fromString('caymus.jpg'));

        $bottles[] = Bottle::create(
            BottleId::fromString('ea1708c2-a1d9-495e-80dc-93b0b61757ed'),
            BottleName::fromString('Vega Sicilia Único'),
            BottleEstateName::fromString('Vega Sicilia'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2011),
            BottleGrapeVarieties::fromArray(['Tempranillo', 'Cabernet Sauvignon']),
            BottleRate::fromString('--'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('Espagne'),
            BottlePrice::fromFloat(1499.99),
        )->addPicture(BottlePicture::fromString('vega-sicilia.webp'));

        $bottles[] = Bottle::create(
            BottleId::fromString('b54cafe9-436e-47a4-9456-61117f6a1648'),
            BottleName::fromString('Cloudy Bay Sauvignon Blanc'),
            BottleEstateName::fromString('Cloudy Bay'),
            BottleWineType::fromString('white'),
            BottleYear::fromInt(2019),
            BottleGrapeVarieties::fromArray(['Sauvignon Blanc']),
            BottleRate::fromString('-'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('New Zealand'),
            BottlePrice::fromFloat(49.99),
        )->addPicture(BottlePicture::fromString('cloudy-bay.png'));

        $bottles[] = Bottle::create(
            BottleId::fromString('e7f247a6-661c-4640-8ac8-25ee1e3eeb6d'),
            BottleName::fromString('Gaja Barbaresco'),
            BottleEstateName::fromString('Gaja'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2016),
            BottleGrapeVarieties::fromArray(['Nebbiolo']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('Italy'),
            BottlePrice::fromFloat(899.99),
        )->addPicture(BottlePicture::fromString('gaja.jpg'));

        $bottles[] = Bottle::create(
            BottleId::fromString('97102d4c-da46-4105-8c34-53f5a2e1e9fa'),
            BottleName::fromString('Ridge Monte Bello'),
            BottleEstateName::fromString('Ridge Vineyards'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2014),
            BottleGrapeVarieties::fromArray(['Cabernet Sauvignon', 'Merlot']),
            BottleRate::fromString('='),
            BottleOwnerId::fromString('root@gmail.com'),
            BottleCountry::fromString('United States'),
            BottlePrice::fromFloat(199.99),
        )->addPicture(BottlePicture::fromString('ridge-vineyards.png'));

        $bottles[] = Bottle::create(
            BottleId::fromString('635e809c-aaaf-40df-8483-83cfbe2c5504'),
            BottleName::fromString('Guigal Côte-Rôtie'),
            BottleEstateName::fromString('E. Guigal'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2014),
            BottleGrapeVarieties::fromArray(['Syrah', 'Viognier']),
            BottleRate::fromString('++'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(358.99),
        );

        foreach ($bottles as $bottle) {
            $manager->persist($bottle);
        }

        $manager->flush();
    }
}
