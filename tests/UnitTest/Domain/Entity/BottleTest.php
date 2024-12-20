<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Tests\UnitTest\BottleInventory\Domain\Entity;

use EmpireDesAmis\BottleInventory\Domain\Entity\Bottle;
use EmpireDesAmis\BottleInventory\Domain\Event\BottleCreated;
use EmpireDesAmis\BottleInventory\Domain\Event\BottleDeleted;
use EmpireDesAmis\BottleInventory\Domain\Event\BottlePictureAdded;
use EmpireDesAmis\BottleInventory\Domain\Event\BottleTasted;
use EmpireDesAmis\BottleInventory\Domain\Event\BottleUpdated;
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
use PHPUnit\Framework\TestCase;

final class BottleTest extends TestCase
{
    public function testCreate(): void
    {
        $bottle = Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        );

        $this->assertInstanceOf(
            Bottle::class,
            $bottle,
        );
        $this->assertEquals(
            'af785dbb-4ac1-4786-a5aa-1fed08f6ec26',
            $bottle->id()->value(),
        );
        $this->assertEquals(
            'Château de Fonsalette',
            $bottle->name()->value(),
        );
        $this->assertEquals(
            'Château Rayas',
            $bottle->estateName()->value(),
        );
        $this->assertEquals(
            'red',
            $bottle->wineType()->value(),
        );
        $this->assertEquals(
            2000,
            $bottle->year()->value(),
        );
        $this->assertEquals(
            ['Grenache', 'Cinsault', 'Syrah'],
            $bottle->grapeVarieties()->values(),
        );
        $this->assertEquals(
            'xs',
            $bottle->rate()->value(),
        );
        $this->assertEquals(
            'hugues.gobet@gmail.com',
            $bottle->ownerId()->value(),
        );
        $this->assertEquals(
            'France',
            $bottle->country()->value(),
        );
        $this->assertEquals(
            12.99,
            $bottle->price()->amount(),
        );
    }

    public function testCreateFailedBadIdLength(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        );
    }

    public function testCreateFailedBadId(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Bottle::create(
            BottleId::fromString('12'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        );
    }

    public function testCreateFailedBadNameTooLong(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('iVvrNxngRgHFxDkHzimAvebLxJaKfmwxPxqVdqTfMVHLeUXWyxJVbGARSkbnegRPvrtJWrjvyTQfAqLUrNXWfrgPXxAwHYqbXzkDgXZRMTqkvFTtvXhAJkrqTHeqCQyEbtGhnJVcSyaNMvmMYwkSzHUhvFTFSCQjjAwjXvWZgdXunMyzNtfJjAkxAyhHjTrURubcAATTHRBfENQKLfHhjUCbhdErTUcGgDSVPSDqrPQcpAecNMpgeDMqncYtVeQf'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        );
    }

    public function testCreateFailedBadNameTooShort(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString(''),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        );
    }

    public function testCreateFailedBadEstateNameTooLong(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('iVvrNxngRgHFxDkHzimAvebLxJaKfmwxPxqVdqTfMVHLeUXWyxJVbGARSkbnegRPvrtJWrjvyTQfAqLUrNXWfrgPXxAwHYqbXzkDgXZRMTqkvFTtvXhAJkrqTHeqCQyEbtGhnJVcSyaNMvmMYwkSzHUhvFTFSCQjjAwjXvWZgdXunMyzNtfJjAkxAyhHjTrURubcAATTHRBfENQKLfHhjUCbhdErTUcGgDSVPSDqrPQcpAecNMpgeDMqncYtVeQf'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        );
    }

    public function testCreateFailedBadEstateNameTooShort(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString(''),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        );
    }

    public function testCreateFailedBadWineType(): void
    {
        $this->expectException(\ValueError::class);

        Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('yellow'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        );
    }

    public function testCreateFailedBadYearToLess(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(1899),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        );
    }

    public function testCreateFailedBadYearToMuch(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2101),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        );
    }

    public function testCreateFailedBadRateValue(): void
    {
        $this->expectException(\ValueError::class);

        Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('top'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        );
    }

    public function testCreateFailedBadCountryTooLong(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('iVvrNxngRgHFxDkHzimAvebLxJaKfmwxPxqVdqTfMVHLeUXWyxJVbGARSkbnegRPvrtJWrjvyTQfAqLUrNXWfrgPXxAwHYqbXzkDgXZRMTqkvFTtvXhAJkrqTHeqCQyEbtGhnJVcSyaNMvmMYwkSzHUhvFTFSCQjjAwjXvWZgdXunMyzNtfJjAkxAyhHjTrURubcAATTHRBfENQKLfHhjUCbhdErTUcGgDSVPSDqrPQcpAecNMpgeDMqncYtVeQf'),
            BottlePrice::fromFloat(12.99),
        );
    }

    public function testCreateFailedBadOwnerIdLength(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('iVvrNxngRgHFxDkHzimAvebLxJaKfmwxPxqVdqTfMVHLeUXWyxJVbGARSkbnegRPvrtJWrjvyTQfAqLUrNXWfrgPXxAwHYqbXzkDgXZRMTqkvFTtvXhAJkrqTHeqCQyEbtGhnJVcSyaNMvmMYwkSzHUhvFTFSCQjjAwjXvWZgdXunMyzNtfJjAkxAyhHjTrURubcAATTHRBfENQKLfHhjUCbhdErTUcGgDSVPSDqrPQcpAecNMpgeDMqncYtVeQf'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        );
    }

    public function testCreateFailedBadOwnerId(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Bottle::create(
            BottleId::fromString('12'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('pedro.gobet'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        );
    }

    public function testCreateFailedBadCountryTooShort(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString(''),
            BottlePrice::fromFloat(12.99),
        );
    }

    public function testCreateFailedBadPriceNegative(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(-12.99),
        );
    }

    public function testAddPicture(): void
    {
        $bottle = Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        )->addPicture(
            BottlePicture::fromString('chateau-de-fonsalette.webp'),
        );

        $this->assertEquals($bottle->picture()->path(), 'chateau-de-fonsalette.webp');
    }

    public function testAddPictureFailedBottlePictureTooLong(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        )->addPicture(
            BottlePicture::fromString('iVvrNxngRgHFxDkHzimAvebLxJaKfmwxPxqVdqTfMVHLeUXWyxJVbGARSkbnegRPvrtJWrjvyTQfAqLUrNXWfrgPXxAwHYqbXzkDgXZRMTqkvFTtvXhAJkrqTHeqCQyEbtGhnJVcSyaNMvmMYwkSzHUhvFTFSCQjjAwjXvWZgdXunMyzNtfJjAkxAyhHjTrURubcAATTHRBfENQKLfHhjUCbhdErTUcGgDSVPSDqrPQcpAecNMpgeDMqncYtVeQf.png'),
        );
    }

    public function testAddPictureFailedBottlePictureTooShort(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        )->addPicture(BottlePicture::fromString('chateau-de-fonsalette.gif'));
    }

    public function testAddPictureFailedBottlePictureBadException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        )->addPicture(BottlePicture::fromString(''));
    }

    public function testTaste(): void
    {
        $bottle = Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        );

        $this->assertNull($bottle->tastedAt());

        $bottle->taste();

        $this->assertNotNull($bottle->tastedAt());
    }

    public function testCreateSuccessEventDispatch(): void
    {
        $bottle = Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        );

        $this->assertInstanceOf(BottleCreated::class, $bottle::getRecordedEvent()[0]);
        $this->assertEquals('af785dbb-4ac1-4786-a5aa-1fed08f6ec26', $bottle::getRecordedEvent()[0]->bottleId);
        $this->assertEquals('Château de Fonsalette', $bottle::getRecordedEvent()[0]->name);
        $this->assertEquals('Château Rayas', $bottle::getRecordedEvent()[0]->estateName);
        $this->assertEquals('red', $bottle::getRecordedEvent()[0]->wineType);
        $this->assertEquals(2000, $bottle::getRecordedEvent()[0]->year);
        $this->assertEquals(['Grenache', 'Cinsault', 'Syrah'], $bottle::getRecordedEvent()[0]->grapeVarieties);
        $this->assertEquals('xs', $bottle::getRecordedEvent()[0]->rate);
        $this->assertEquals('hugues.gobet@gmail.com', $bottle::getRecordedEvent()[0]->ownerId);
        $this->assertNotNull($bottle::getRecordedEvent()[0]->savedAt);
        $this->assertEquals('France', $bottle::getRecordedEvent()[0]->country);
        $this->assertEquals(12.99, $bottle::getRecordedEvent()[0]->price);
        $bottle::eraseRecordedEvents();
    }

    public function testCreateFailedNoEventDispatch(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $bottle = Bottle::create(
            BottleId::fromString('12'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        );

        $this->assertEmpty($bottle::getRecordedEvent()[0]);
    }

    public function testPictureAddedSuccessEventDispatch(): void
    {
        $bottle = Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        );

        $bottle::eraseRecordedEvents();

        $bottle->addPicture(
            BottlePicture::fromString('chateau-de-fonsalette.webp'),
        );

        $this->assertInstanceOf(BottlePictureAdded::class, $bottle::getRecordedEvent()[0]);
        $this->assertEquals('af785dbb-4ac1-4786-a5aa-1fed08f6ec26', $bottle::getRecordedEvent()[0]->bottleId);
        $this->assertEquals('chateau-de-fonsalette.webp', $bottle::getRecordedEvent()[0]->picture);
        $bottle::eraseRecordedEvents();
    }

    public function testPictureAddFailedNoEventDispatch(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $bottle = Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        );

        $bottle::eraseRecordedEvents();

        $bottle->addPicture(
            BottlePicture::fromString('iVvrNxngRgHFxDkHzimAvebLxJaKfmwxPxqVdqTfMVHLeUXWyxJVbGARSkbnegRPvrtJWrjvyTQfAqLUrNXWfrgPXxAwHYqbXzkDgXZRMTqkvFTtvXhAJkrqTHeqCQyEbtGhnJVcSyaNMvmMYwkSzHUhvFTFSCQjjAwjXvWZgdXunMyzNtfJjAkxAyhHjTrURubcAATTHRBfENQKLfHhjUCbhdErTUcGgDSVPSDqrPQcpAecNMpgeDMqncYtVeQf.png'),
        );

        $this->assertEmpty($bottle::getRecordedEvent()[0]);
    }

    public function testTasteSuccessEventDispatch(): void
    {
        $bottle = Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        );

        $bottle::eraseRecordedEvents();

        $bottle->taste();

        $this->assertInstanceOf(BottleTasted::class, $bottle::getRecordedEvent()[0]);
        $this->assertEquals('af785dbb-4ac1-4786-a5aa-1fed08f6ec26', $bottle::getRecordedEvent()[0]->bottleId);
        $this->assertEquals('Château de Fonsalette', $bottle::getRecordedEvent()[0]->bottleName);
        $this->assertEquals('red', $bottle::getRecordedEvent()[0]->bottleWineType);
        $this->assertEquals('hugues.gobet@gmail.com', $bottle::getRecordedEvent()[0]->ownerId);
        $this->assertEquals((new \DateTimeImmutable())->format('Y-m-d'), $bottle::getRecordedEvent()[0]->tastedAt);
        $bottle::eraseRecordedEvents();
    }

    public function testDeleteSuccessEventDispatch(): void
    {
        $bottle = Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        );

        $bottle::eraseRecordedEvents();

        $bottle->delete();

        $this->assertInstanceOf(BottleDeleted::class, $bottle::getRecordedEvent()[0]);
        $bottle::eraseRecordedEvents();
    }

    public function testUpdate(): void
    {
        $bottle = Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        );

        $bottle::eraseRecordedEvents();

        $bottle->update(
            BottleName::fromString('Vouvray moelleux - cuvée constance'),
            BottleEstateName::fromString('Domaine Huet'),
            BottleWineType::fromString('white'),
            BottleYear::fromInt(2018),
            BottleGrapeVarieties::fromArray(['Chenin']),
            BottleRate::fromString('++'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(120.99),
        );

        $this->assertEquals('Vouvray moelleux - cuvée constance', $bottle->name()->value());
        $this->assertEquals('Domaine Huet', $bottle->estateName()->value());
        $this->assertEquals('white', $bottle->wineType()->value());
        $this->assertEquals(2018, $bottle->year()->value());
        $this->assertEquals(['Chenin'], $bottle->grapeVarieties()->values());
        $this->assertEquals('++', $bottle->rate()->value());
        $this->assertEquals('France', $bottle->country()->value());
        $this->assertEquals(120.99, $bottle->price()->amount());
    }

    public function testUpdateSuccessEventDispatch(): void
    {
        $bottle = Bottle::create(
            BottleId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            BottleName::fromString('Château de Fonsalette'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2000),
            BottleGrapeVarieties::fromArray(['Grenache', 'Cinsault', 'Syrah']),
            BottleRate::fromString('xs'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(12.99),
        );

        $bottle::eraseRecordedEvents();

        $bottle->update(
            BottleName::fromString('Vouvray moelleux - cuvée constance'),
            BottleEstateName::fromString('Domaine Huet'),
            BottleWineType::fromString('white'),
            BottleYear::fromInt(2018),
            BottleGrapeVarieties::fromArray(['Chenin']),
            BottleRate::fromString('++'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(120.99),
        );

        $this->assertInstanceOf(BottleUpdated::class, $bottle::getRecordedEvent()[0]);
        $this->assertEquals('af785dbb-4ac1-4786-a5aa-1fed08f6ec26', $bottle::getRecordedEvent()[0]->bottleId);
        $this->assertEquals('Vouvray moelleux - cuvée constance', $bottle::getRecordedEvent()[0]->name);
        $this->assertEquals('Domaine Huet', $bottle::getRecordedEvent()[0]->estateName);
        $this->assertEquals('white', $bottle::getRecordedEvent()[0]->wineType);
        $this->assertEquals(2018, $bottle::getRecordedEvent()[0]->year);
        $this->assertEquals(['Chenin'], $bottle::getRecordedEvent()[0]->grapeVarieties);
        $this->assertEquals('++', $bottle::getRecordedEvent()[0]->rate);
        $this->assertEquals('France', $bottle::getRecordedEvent()[0]->country);
        $this->assertEquals(120.99, $bottle::getRecordedEvent()[0]->price);

        $bottle::eraseRecordedEvents();
    }
}
