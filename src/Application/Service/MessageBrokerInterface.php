<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Service;

use EmpireDesAmis\BottleInventory\Domain\Event\BottleTasted;

interface MessageBrokerInterface
{
    public function dispatchBottleTastedMessage(BottleTasted $event): void;
}
