<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Tests\AdapterTest\DrivingTest\BottleInventory\Application\Projection;

use EmpireDesAmis\BottleInventory\Application\Adapter\BottleListAdapterInterface;
use EmpireDesAmis\BottleInventory\Application\Exception\BottleDoesntExistException;
use EmpireDesAmis\BottleInventory\Application\Projection\UpdateBottleListProjection;
use EmpireDesAmis\BottleInventory\Domain\Event\BottleUpdated;
use EmpireDesAmis\BottleInventory\Tests\Shared\RefreshDatabase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class UpdateBottleListProjectionTest extends KernelTestCase
{
    use RefreshDatabase;
    private readonly UpdateBottleListProjection $updateBottleListProjection;
    private readonly BottleListAdapterInterface $bottleListAdapter;

    public function testUpdateBottleListProjection(): void
    {
        self::bootKernel();

        $container = self::getContainer();
        $this->updateBottleListProjection = $container->get(UpdateBottleListProjection::class);
        $projection = $this->updateBottleListProjection;
        $this->bottleListAdapter = $container->get(BottleListAdapterInterface::class);

        $event = new BottleUpdated(
            '7bd55df3-e53c-410b-83a4-8e5ed9bcd50d',
            'Château Rayas',
            'Château Rayas',
            'white',
            2005,
            ['Merlot', 'Cabernet Franc'],
            '++',
            'Portugal',
            10.09,
        );

        $projection($event);

        $bottleList = $this->bottleListAdapter->ofId('7bd55df3-e53c-410b-83a4-8e5ed9bcd50d');
        $this->assertEquals('Château Rayas', $bottleList->name);
        $this->assertEquals('Château Rayas', $bottleList->estateName);
        $this->assertEquals('white', $bottleList->wineType);
        $this->assertEquals(2005, $bottleList->year);
        $this->assertEquals('++', $bottleList->rate);
    }

    public function testUpdateBottleListProjectionFailed(): void
    {
        self::bootKernel();

        $container = static::getContainer();
        $projection = $this->updateBottleListProjection = $container->get(UpdateBottleListProjection::class);

        $event = new BottleUpdated(
            'aacb6bce-1111-42e0-852e-f9813abb49fa',
            'Château Rayas',
            'Château Rayas',
            'white',
            2005,
            ['Merlot', 'Cabernet Franc'],
            '++',
            'Portugal',
            10.09,
        );

        $this->expectException(BottleDoesntExistException::class);
        $this->expectExceptionMessage('Bottle aacb6bce-1111-42e0-852e-f9813abb49fa does not exist');

        $projection($event);
    }
}
