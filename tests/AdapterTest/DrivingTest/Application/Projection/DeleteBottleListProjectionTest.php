<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Tests\AdapterTest\DrivingTest\BottleInventory\Application\Projection;

use EmpireDesAmis\BottleInventory\Application\Adapter\BottleListAdapterInterface;
use EmpireDesAmis\BottleInventory\Application\Exception\BottleDoesntExistException;
use EmpireDesAmis\BottleInventory\Application\Projection\DeleteBottleListProjection;
use EmpireDesAmis\BottleInventory\Application\ReadModel\BottleList;
use EmpireDesAmis\BottleInventory\Domain\Event\BottleDeleted;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class DeleteBottleListProjectionTest extends KernelTestCase
{
    private DeleteBottleListProjection $deleteBottleListProjection;
    private BottleListAdapterInterface $bottleListAdapter;

    public function testDeleteBottleProjection(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        $deleteBottleListProjection = $this->deleteBottleListProjection = $container->get(DeleteBottleListProjection::class);
        $this->bottleListAdapter = $container->get(BottleListAdapterInterface::class);

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

        $this->bottleListAdapter->add($bottle);
        $this->assertNotNull(
            $this->bottleListAdapter->ofId('b5880b05-073b-4224-95ed-21af2cf4e737'),
        );

        $event = new BottleDeleted(
            'b5880b05-073b-4224-95ed-21af2cf4e737',
        );

        $deleteBottleListProjection($event);

        $this->assertNull(
            $this->bottleListAdapter->ofId('b5880b05-073b-4224-95ed-21af2cf4e737'),
        );
    }

    public function testDeleteBottleListProjectionFailed(): void
    {
        self::bootKernel();

        $container = static::getContainer();
        $projection = $this->deleteBottleListProjection = $container->get(DeleteBottleListProjection::class);

        $event = new BottleDeleted(
            'aacb6bce-1111-42e0-852e-f9813abb49fa',
        );

        $this->expectException(BottleDoesntExistException::class);
        $this->expectExceptionMessage('Bottle aacb6bce-1111-42e0-852e-f9813abb49fa does not exist');

        $projection($event);
    }
}
