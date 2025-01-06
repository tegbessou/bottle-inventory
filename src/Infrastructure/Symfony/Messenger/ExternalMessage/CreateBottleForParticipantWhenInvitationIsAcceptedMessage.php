<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\Symfony\Messenger\ExternalMessage;

final readonly class CreateBottleForParticipantWhenInvitationIsAcceptedMessage
{
    public function __construct(
        public string $bottleId,
        public string $participant,
    ) {
    }
}
