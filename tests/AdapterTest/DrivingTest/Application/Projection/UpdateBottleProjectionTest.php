<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Tests\AdapterTest\DrivingTest\BottleInventory\Application\Projection;

use EmpireDesAmis\BottleInventory\Application\Adapter\BottleAdapterInterface;
use EmpireDesAmis\BottleInventory\Application\Exception\BottleDoesntExistException;
use EmpireDesAmis\BottleInventory\Application\Projection\UpdateBottleProjection;
use EmpireDesAmis\BottleInventory\Domain\Event\BottleUpdated;
use EmpireDesAmis\BottleInventory\Tests\Shared\RefreshDatabase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class UpdateBottleProjectionTest extends KernelTestCase
{
    use RefreshDatabase;

    private readonly UpdateBottleProjection $updateBottleProjection;
    private readonly BottleAdapterInterface $bottleAdapter;

    public function testUpdateBottleProjection(): void
    {
        self::bootKernel();

        $container = self::getContainer();
        $this->updateBottleProjection = $container->get(UpdateBottleProjection::class);
        $projection = $this->updateBottleProjection;
        $this->bottleAdapter = $container->get(BottleAdapterInterface::class);

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

        $bottle = $this->bottleAdapter->ofId('7bd55df3-e53c-410b-83a4-8e5ed9bcd50d');
        $this->assertEquals('Château Rayas', $bottle->name);
        $this->assertEquals('Château Rayas', $bottle->estateName);
        $this->assertEquals('white', $bottle->wineType);
        $this->assertEquals(2005, $bottle->year);
        $this->assertEquals(['Merlot', 'Cabernet Franc'], $bottle->grapeVarieties);
        $this->assertEquals('++', $bottle->rate);
        $this->assertEquals('Portugal', $bottle->country);
        $this->assertEquals(10.09, $bottle->price);
    }

    public function testUpdateBottleProjectionFailed(): void
    {
        self::bootKernel();

        $container = static::getContainer();
        $projection = $this->updateBottleProjection = $container->get(UpdateBottleProjection::class);

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
