<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Tests\AdapterTest\DrivingTest\BottleInventory\Application\Projection;

use EmpireDesAmis\BottleInventory\Application\Adapter\BottleAdapterInterface;
use EmpireDesAmis\BottleInventory\Application\Projection\CreateBottleProjection;
use EmpireDesAmis\BottleInventory\Domain\Entity\Bottle;
use EmpireDesAmis\BottleInventory\Domain\Event\BottleCreated;
use EmpireDesAmis\BottleInventory\Domain\Repository\BottleRepositoryInterface;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleCountry;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleEstateName;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleGrapeVarieties;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleId;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleName;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleOwnerId;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottlePrice;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleRate;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleWineType;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleYear;
use EmpireDesAmis\BottleInventory\Tests\Shared\RefreshDatabase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class CreateBottleProjectionTest extends KernelTestCase
{
    use RefreshDatabase;

    private readonly CreateBottleProjection $bottleProjection;
    private readonly BottleAdapterInterface $bottleAdapter;
    private readonly BottleRepositoryInterface $bottleRepository;

    public function testBottleProjection(): void
    {
        self::bootKernel();

        $container = static::getContainer();
        $projection = $this->bottleProjection = $container->get(CreateBottleProjection::class);
        $this->bottleAdapter = $container->get(BottleAdapterInterface::class);
        $this->bottleRepository = $container->get(BottleRepositoryInterface::class);

        $bottleEntity = Bottle::create(
            BottleId::fromString('4ad98deb-4295-455d-99e2-66e148c162af'),
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
        $bottleEntity::eraseRecordedEvents();

        $this->bottleRepository->add($bottleEntity);

        $event = new BottleCreated(
            '4ad98deb-4295-455d-99e2-66e148c162af',
            'Château de Fonsalette',
            'Château Rayas',
            'red',
            2000,
            'xs',
            ['Grenache', 'Cinsault', 'Syrah'],
            'hugues.gobet@gmail.com',
            '2000-01-01',
            'France',
            12.99,
        );

        $projection($event);

        $bottle = $this->bottleAdapter->ofId('4ad98deb-4295-455d-99e2-66e148c162af');
        $this->assertNotNull($bottle);

        $bottleEntity = $this->bottleRepository->ofId(
            BottleId::fromString('4ad98deb-4295-455d-99e2-66e148c162af'),
        );
        $this->bottleRepository->delete($bottleEntity);
    }
}
