<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\Symfony\Messenger;

use EmpireDesAmis\BottleInventory\Application\Service\MessageBrokerInterface;
use EmpireDesAmis\BottleInventory\Domain\Event\BottleTasted;
use EmpireDesAmis\BottleInventory\Infrastructure\Symfony\Messenger\Message\BottleTastedMessage;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class MessengerBroker implements MessageBrokerInterface
{
    public function __construct(
        private MessageBusInterface $eventBus,
    ) {
    }

    #[\Override]
    public function dispatchBottleTastedMessage(BottleTasted $event): void
    {
        $this->eventBus->dispatch(
            BottleTastedMessage::fromEvent($event)
        );
    }
}
