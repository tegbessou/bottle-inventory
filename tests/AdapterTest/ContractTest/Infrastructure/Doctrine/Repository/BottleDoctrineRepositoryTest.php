<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Tests\AdapterTest\ContractTest\Infrastructure\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use EmpireDesAmis\BottleInventory\Domain\Entity\Bottle;
use EmpireDesAmis\BottleInventory\Domain\Repository\BottleRepositoryInterface;
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
use EmpireDesAmis\BottleInventory\Tests\Shared\RefreshDatabase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class BottleDoctrineRepositoryTest extends KernelTestCase
{
    use RefreshDatabase;

    private EntityManagerInterface $entityManager;

    private BottleRepositoryInterface $doctrineBottleRepository;

    #[\Override]
    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        $this->doctrineBottleRepository = $container->get(BottleRepositoryInterface::class);
        $this->entityManager = $container->get(EntityManagerInterface::class);

        parent::setUp();
    }

    public function testOfId(): void
    {
        $this->assertNotNull(
            $this->doctrineBottleRepository->ofId(BottleId::fromString('7bd55df3-e53c-410b-83a4-8e5ed9bcd50d')),
        );
    }

    public function testOfIdNull(): void
    {
        $this->assertNull(
            $this->doctrineBottleRepository->ofId(BottleId::fromString('4fd831f2-5717-43c1-88de-cdc93bb955c7')),
        );
    }

    public function testAddWithAllInformation(): void
    {
        $bottle = Bottle::create(
            BottleId::fromString('2ccee98f-f2d2-4aaa-b059-7c38bb7e57cf'),
            BottleName::fromString('Château Rayas'),
            BottleEstateName::fromString('Château Rayas'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2015),
            BottleGrapeVarieties::fromArray(['Grenache']),
            BottleRate::fromString('+'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(129.99),
        );

        $this->doctrineBottleRepository->add($bottle);

        $bottle::eraseRecordedEvents();

        $this->assertNotNull(
            $this->doctrineBottleRepository->ofId(BottleId::fromString('2ccee98f-f2d2-4aaa-b059-7c38bb7e57cf')),
        );
    }

    public function testNextIdentity(): void
    {
        $nextIdentity = $this->doctrineBottleRepository->nextIdentity();

        $this->assertIsString($nextIdentity->value());
    }

    public function testUpdate(): void
    {
        $bottle = $this->doctrineBottleRepository->ofId(
            BottleId::fromString('635e809c-aaaf-40df-8483-83cfbe2c5504')
        );

        $this->assertNull(
            $bottle->picture()?->path(),
        );

        $bottle->addPicture(BottlePicture::fromString('picture.jpg'));
        $this->doctrineBottleRepository->update($bottle);

        $bottle::eraseRecordedEvents();

        $bottleUpdated = $this->doctrineBottleRepository->ofId(
            BottleId::fromString('635e809c-aaaf-40df-8483-83cfbe2c5504')
        );

        $this->assertNotNull(
            $bottleUpdated->picture(),
        );
    }

    public function testDelete(): void
    {
        $bottle = Bottle::create(
            BottleId::fromString('9b676c71-3ad3-4c67-a464-aefef9f1940a'),
            BottleName::fromString('Mercurey 1er cru clos l\'évêque'),
            BottleEstateName::fromString('Maison Patriarche'),
            BottleWineType::fromString('red'),
            BottleYear::fromInt(2018),
            BottleGrapeVarieties::fromArray(['Pinot Noir']),
            BottleRate::fromString('-'),
            BottleOwnerId::fromString('hugues.gobet@gmail.com'),
            BottleCountry::fromString('France'),
            BottlePrice::fromFloat(29.90),
        );

        $this->doctrineBottleRepository->add($bottle);

        $bottle::eraseRecordedEvents();

        $this->doctrineBottleRepository->delete($bottle);

        $bottleDeleted = $this->doctrineBottleRepository->ofId(
            BottleId::fromString('9b676c71-3ad3-4c67-a464-aefef9f1940a')
        );

        $this->assertNull(
            $bottleDeleted,
        );
    }
}
