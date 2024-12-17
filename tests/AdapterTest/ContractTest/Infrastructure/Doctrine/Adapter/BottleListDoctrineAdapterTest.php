<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Tests\AdapterTest\ContractTest\Infrastructure\Doctrine\Adapter;

use EmpireDesAmis\BottleInventory\Application\Adapter\BottleListAdapterInterface;
use EmpireDesAmis\BottleInventory\Application\ReadModel\BottleList;
use EmpireDesAmis\BottleInventory\Tests\Shared\RefreshDatabase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class BottleListDoctrineAdapterTest extends KernelTestCase
{
    use RefreshDatabase;
    private readonly BottleListAdapterInterface $bottleListDoctrineAdapter;

    #[\Override]
    protected function setUp(): void
    {
        self::bootKernel();

        $container = self::getContainer();
        $this->bottleListDoctrineAdapter = $container->get(BottleListAdapterInterface::class);
    }

    public function testAdd(): void
    {
        $bottle = new BottleList(
            'b5880b05-073b-4224-95ed-21af2cf4e737',
            'Château Margaux',
            'Château Margaux',
            '++',
            2015,
            'red',
            '2021-01-01',
            'hugues.gobet@gmail.com',
        );

        $this->bottleListDoctrineAdapter->add($bottle);

        $bottle = $this->bottleListDoctrineAdapter->ofId('b5880b05-073b-4224-95ed-21af2cf4e737');
        $this->assertNotNull($bottle);
    }

    public function testOfId(): void
    {
        $this->assertNotNull(
            $this->bottleListDoctrineAdapter->ofId('7bd55df3-e53c-410b-83a4-8e5ed9bcd50d'),
        );
    }

    public function testOfIdNull(): void
    {
        $this->assertNull(
            $this->bottleListDoctrineAdapter->ofId('324ad167-1805-4a61-b2d3-3832e7a4e286'),
        );
    }

    public function testUpdate(): void
    {
        $bottle = new BottleList(
            'b5880b05-073b-4224-95ed-21af2cf4e737',
            'Château Margaux',
            'Château Margaux',
            '++',
            2015,
            'red',
            '2021-01-01',
            'hugues.gobet@gmail.com',
        );

        $this->bottleListDoctrineAdapter->add($bottle);

        $bottle = $this->bottleListDoctrineAdapter->ofId('b5880b05-073b-4224-95ed-21af2cf4e737');

        $bottle->picture = 'cheateau-margaux.jpg';

        $this->bottleListDoctrineAdapter->update($bottle);

        $bottle = $this->bottleListDoctrineAdapter->ofId('b5880b05-073b-4224-95ed-21af2cf4e737');
        $this->assertEquals('cheateau-margaux.jpg', $bottle->picture);
    }

    public function testSortName(): void
    {
        $bottles = $this->bottleListDoctrineAdapter->sortName()
            ->getIterator()
        ;

        $this->assertEquals('Caymus Vineyards Special Selection Cabernet Sauvignon', $bottles->current()->name);
    }

    public function testWithName(): void
    {
        $bottles = $this->bottleListDoctrineAdapter->withName('Chateau')
            ->getIterator()
        ;

        $this->assertNotNull($bottles->current());
        $this->assertStringContainsString('Château', $bottles->current()->name);
    }

    public function testWithEstateName(): void
    {
        $bottles = $this->bottleListDoctrineAdapter->withEstateName('Chateau')
            ->getIterator()
        ;

        $this->assertNotNull($bottles->current());
        $this->assertStringContainsString('Château', $bottles->current()->estateName);
    }

    public function testWithYear(): void
    {
        $bottles = $this->bottleListDoctrineAdapter->withYear(2011)
            ->getIterator()
        ;

        $this->assertNotNull($bottles->current());
        $this->assertEquals(2011, $bottles->current()->year);
    }

    public function testWithRate(): void
    {
        $bottles = $this->bottleListDoctrineAdapter->withRate('++')
            ->getIterator()
        ;

        $this->assertNotNull($bottles->current());
        $this->assertEquals('++', $bottles->current()->rate);
    }

    public function testWithWineType(): void
    {
        $bottles = $this->bottleListDoctrineAdapter->withWineType('white')
            ->getIterator()
        ;

        $this->assertNotNull($bottles->current());
        $this->assertEquals('white', $bottles->current()->wineType);
    }
}
