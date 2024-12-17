<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Tests\AdapterTest\DrivingTest\BottleInventory\Application\Projection;

use EmpireDesAmis\BottleInventory\Application\Adapter\BottleAdapterInterface;
use EmpireDesAmis\BottleInventory\Application\Exception\BottleDoesntExistException;
use EmpireDesAmis\BottleInventory\Application\Projection\DeleteBottleProjection;
use EmpireDesAmis\BottleInventory\Application\ReadModel\Bottle;
use EmpireDesAmis\BottleInventory\Domain\Event\BottleDeleted;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class DeleteBottleProjectionTest extends KernelTestCase
{
    private DeleteBottleProjection $deleteBottleProjection;
    private BottleAdapterInterface $bottleAdapter;

    public function testDeleteBottleProjection(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        $deleteBottleProjection = $this->deleteBottleProjection = $container->get(DeleteBottleProjection::class);
        $this->bottleAdapter = $container->get(BottleAdapterInterface::class);

        $bottle = new Bottle(
            'b5880b05-073b-4224-95ed-21af2cf4e737',
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
        );

        $this->bottleAdapter->add($bottle);
        $this->assertNotNull(
            $this->bottleAdapter->ofId('b5880b05-073b-4224-95ed-21af2cf4e737'),
        );

        $event = new BottleDeleted(
            'b5880b05-073b-4224-95ed-21af2cf4e737',
        );

        $deleteBottleProjection($event);

        $this->assertNull(
            $this->bottleAdapter->ofId('b5880b05-073b-4224-95ed-21af2cf4e737'),
        );
    }

    public function testDeleteBottleProjectionFailed(): void
    {
        self::bootKernel();

        $container = static::getContainer();
        $projection = $this->deleteBottleProjection = $container->get(DeleteBottleProjection::class);

        $event = new BottleDeleted(
            'aacb6bce-1111-42e0-852e-f9813abb49fa',
        );

        $this->expectException(BottleDoesntExistException::class);
        $this->expectExceptionMessage('Bottle aacb6bce-1111-42e0-852e-f9813abb49fa does not exist');

        $projection($event);
    }
}
