<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Tests\UnitTest\BottleInventory\Domain\Entity;

use EmpireDesAmis\BottleInventory\Domain\Entity\GrapeVariety;
use EmpireDesAmis\BottleInventory\Domain\Event\GrapeVarietyCreated;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\GrapeVarietyId;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\GrapeVarietyName;
use PHPUnit\Framework\TestCase;

final class GrapeVarietyTest extends TestCase
{
    public function testCreateSuccess(): void
    {
        $grapeVariety = GrapeVariety::create(
            GrapeVarietyId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            GrapeVarietyName::fromString('Sirano'),
        );

        $this->assertInstanceOf(
            GrapeVariety::class,
            $grapeVariety,
        );
        $this->assertEquals(
            'af785dbb-4ac1-4786-a5aa-1fed08f6ec26',
            $grapeVariety->id()->value(),
        );
        $this->assertEquals(
            'Sirano',
            $grapeVariety->name()->value(),
        );
    }

    public function testCreateBadIdLength(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        GrapeVariety::create(
            GrapeVarietyId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26-1fed08f6ec26'),
            GrapeVarietyName::fromString('Selenor'),
        );
    }

    public function testCreateBadId(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        GrapeVariety::create(
            GrapeVarietyId::fromString('12'),
            GrapeVarietyName::fromString('Selenor'),
        );
    }

    public function testCreateBadNameTooShort(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        GrapeVariety::create(
            GrapeVarietyId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            GrapeVarietyName::fromString(''),
        );
    }

    public function testCreateBadNameTooLong(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        GrapeVariety::create(
            GrapeVarietyId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            GrapeVarietyName::fromString('iVvrNxngRgHFxDkHzimAvebLxJaKfmwxPxqVdqTfMVHLeUXWyxJVbGARSkbnegRPvrtJWrjvyTQfAqLUrNXWfrgPXxAwHYqbXzkDgXZRMTqkvFTtvXhAJkrqTHeqCQyEbtGhnJVcSyaNMvmMYwkSzHUhvFTFSCQjjAwjXvWZgdXunMyzNtfJjAkxAyhHjTrURubcAATTHRBfENQKLfHhjUCbhdErTUcGgDSVPSDqrPQcpAecNMpgeDMqncYtVeQf'),
        );
    }

    public function testCreateSuccessEventDispatch(): void
    {
        $grapeVariety = GrapeVariety::create(
            GrapeVarietyId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            GrapeVarietyName::fromString('Sirano'),
        );

        $this->assertInstanceOf(GrapeVarietyCreated::class, $grapeVariety::getRecordedEvent()[0]);
        $grapeVariety::eraseRecordedEvents();
    }

    public function testCreateFailedNoEventDispatch(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $grapeVariety = GrapeVariety::create(
            GrapeVarietyId::fromString('af785dbb-4ac1-4786-a5aa-1fed08f6ec26'),
            GrapeVarietyName::fromString(''),
        );

        $this->assertEmpty($grapeVariety::getRecordedEvent()[0]);
    }
}
