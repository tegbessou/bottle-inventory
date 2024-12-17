<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Tests\AdapterTest\DrivingTest\BottleInventory\Application\Projection;

use EmpireDesAmis\BottleInventory\Application\Adapter\BottleListAdapterInterface;
use EmpireDesAmis\BottleInventory\Application\Exception\BottleDoesntExistException;
use EmpireDesAmis\BottleInventory\Application\Projection\AddPictureBottleListProjection;
use EmpireDesAmis\BottleInventory\Domain\Event\BottlePictureAdded;
use EmpireDesAmis\BottleInventory\Tests\Shared\RefreshDatabase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class AddPictureBottleListProjectionTest extends KernelTestCase
{
    use RefreshDatabase;

    private readonly AddPictureBottleListProjection $addPictureBottleListProjection;
    private readonly BottleListAdapterInterface $bottleListAdapter;

    public function testBottleProjection(): void
    {
        self::bootKernel();

        $container = static::getContainer();
        $projection = $this->addPictureBottleListProjection = $container->get(AddPictureBottleListProjection::class);
        $this->bottleListAdapter = $container->get(BottleListAdapterInterface::class);

        $event = new BottlePictureAdded(
            '7bd55df3-e53c-410b-83a4-8e5ed9bcd50d',
            'chateau-margaux.jpg',
        );

        $projection($event);

        $bottle = $this->bottleListAdapter->ofId('7bd55df3-e53c-410b-83a4-8e5ed9bcd50d');
        $this->assertEquals('chateau-margaux.jpg', $bottle->picture);
    }

    public function testBottleProjectionFailed(): void
    {
        self::bootKernel();

        $container = static::getContainer();
        $projection = $this->addPictureBottleListProjection = $container->get(AddPictureBottleListProjection::class);

        $event = new BottlePictureAdded(
            'aacb6bce-1111-42e0-852e-f9813abb49fa',
            'chateau-margaux.jpg',
        );

        $this->expectException(BottleDoesntExistException::class);
        $this->expectExceptionMessage('Bottle aacb6bce-1111-42e0-852e-f9813abb49fa does not exist');

        $projection($event);
    }
}
