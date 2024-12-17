<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\Symfony\Messenger\Message;

use EmpireDesAmis\BottleInventory\Domain\Event\BottleTasted;

final readonly class BottleTastedMessage
{
    public function __construct(
        public string $bottleId,
        public string $ownerEmail,
    ) {
    }

    public static function fromEvent(
        BottleTasted $event,
    ): self {
        return new self(
            $event->bottleId,
            $event->ownerId,
        );
    }
}
