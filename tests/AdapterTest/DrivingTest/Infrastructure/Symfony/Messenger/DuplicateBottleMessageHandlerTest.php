<?php

declare(strict_types=1);

namespace AdapterTest\DrivingTest\Infrastructure\Symfony\Messenger;

use Doctrine\ORM\EntityManagerInterface;
use EmpireDesAmis\BottleInventory\Infrastructure\Doctrine\Entity\Bottle;
use EmpireDesAmis\BottleInventory\Infrastructure\Symfony\Messenger\ExternalMessage\CreateBottleForParticipantWhenInvitationIsAcceptedMessage;
use EmpireDesAmis\BottleInventory\Tests\Shared\RefreshDatabase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Messenger\Test\InteractsWithMessenger;

final class DuplicateBottleMessageHandlerTest extends KernelTestCase
{
    use InteractsWithMessenger;
    use RefreshDatabase;

    private EntityManagerInterface $entityManager;

    #[\Override]
    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        $this->entityManager = $container->get(EntityManagerInterface::class);

        parent::setUp();
    }

    public function testDuplicateBottle(): void
    {
        $this->bus('event.bus')->dispatch(new CreateBottleForParticipantWhenInvitationIsAcceptedMessage(
            '7bd55df3-e53c-410b-83a4-8e5ed9bcd50d',
            'root@gmail.com',
        ));

        $bottles = $this->entityManager->getRepository(Bottle::class)->findBy([
            'ownerId' => 'root@gmail.com',
        ]);

        $oldCount = count($bottles);

        $this->assertCount($oldCount, $bottles);

        $this->transport('bottle_inventory_from_external')->queue()->assertContains(CreateBottleForParticipantWhenInvitationIsAcceptedMessage::class, 1);
        $this->transport('bottle_inventory_from_external')->process(1);
        $this->transport('bottle_inventory_from_external')->queue()->assertContains(CreateBottleForParticipantWhenInvitationIsAcceptedMessage::class, 0);

        $bottles = $this->entityManager->getRepository(Bottle::class)->findBy([
            'ownerId' => 'root@gmail.com',
        ]);

        $this->assertCount($oldCount + 1, $bottles);
    }
}
