<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\EventListener;

use EmpireDesAmis\BottleInventory\Application\Service\MessageBrokerInterface;
use EmpireDesAmis\BottleInventory\Domain\Event\BottleTasted;

final readonly class OnBottleTasted
{
    public function __construct(
        private MessageBrokerInterface $messageBrokerService,
    ) {
    }

    public function __invoke(BottleTasted $event): void
    {
        $this->messageBrokerService->dispatchBottleTastedMessage(
            $event,
        );
    }
}
