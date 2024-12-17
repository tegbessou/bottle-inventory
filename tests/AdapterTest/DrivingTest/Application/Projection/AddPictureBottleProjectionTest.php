<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Tests\AdapterTest\DrivingTest\BottleInventory\Application\Projection;

use EmpireDesAmis\BottleInventory\Application\Adapter\BottleAdapterInterface;
use EmpireDesAmis\BottleInventory\Application\Exception\BottleDoesntExistException;
use EmpireDesAmis\BottleInventory\Application\Projection\AddPictureBottleProjection;
use EmpireDesAmis\BottleInventory\Domain\Event\BottlePictureAdded;
use EmpireDesAmis\BottleInventory\Tests\Shared\RefreshDatabase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class AddPictureBottleProjectionTest extends KernelTestCase
{
    use RefreshDatabase;

    private readonly AddPictureBottleProjection $addPictureBottleProjection;
    private readonly BottleAdapterInterface $bottleAdapter;

    public function testBottleProjection(): void
    {
        self::bootKernel();

        $container = static::getContainer();
        $projection = $this->addPictureBottleProjection = $container->get(AddPictureBottleProjection::class);
        $this->bottleAdapter = $container->get(BottleAdapterInterface::class);

        $event = new BottlePictureAdded(
            '7bd55df3-e53c-410b-83a4-8e5ed9bcd50d',
            'chateau-margaux.jpg',
        );

        $projection($event);

        $bottle = $this->bottleAdapter->ofId('7bd55df3-e53c-410b-83a4-8e5ed9bcd50d');
        $this->assertEquals('chateau-margaux.jpg', $bottle->picture);

        $bottle->picture = null;

        $bottle = $this->bottleAdapter->ofId('7bd55df3-e53c-410b-83a4-8e5ed9bcd50d');
        $this->assertNull($bottle->picture);
    }

    public function testBottleProjectionFailed(): void
    {
        self::bootKernel();

        $container = static::getContainer();
        $projection = $this->addPictureBottleProjection = $container->get(AddPictureBottleProjection::class);

        $event = new BottlePictureAdded(
            'aacb6bce-1111-42e0-852e-f9813abb49fa',
            'chateau-margaux.jpg',
        );

        $this->expectException(BottleDoesntExistException::class);
        $this->expectExceptionMessage('Bottle aacb6bce-1111-42e0-852e-f9813abb49fa does not exist');

        $projection($event);
    }
}
