<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\Symfony\Messenger\Serializer;

use EmpireDesAmis\BottleInventory\Infrastructure\Symfony\Messenger\ExternalMessage\CreateBottleForParticipantWhenInvitationIsAcceptedMessage;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

final class ExternalMessageSerializer implements SerializerInterface
{
    private const string CREATE_BOTTLE_FOR_PARTICIPANT_WHEN_INVITATION_IS_ACCEPTED_MESSAGE = 'CreateBottleForParticipantWhenInvitationIsAcceptedMessage';

    #[\Override]
    public function decode(array $encodedEnvelope): Envelope
    {
        $body = $encodedEnvelope['body'];
        $headers = $encodedEnvelope['headers'];
        $data = json_decode((string) $body, true);

        if (str_contains((string) $headers['type'], self::CREATE_BOTTLE_FOR_PARTICIPANT_WHEN_INVITATION_IS_ACCEPTED_MESSAGE)) {
            return new Envelope(new CreateBottleForParticipantWhenInvitationIsAcceptedMessage(
                $data['bottleId'],
                $data['participant'],
            ));
        }

        throw new \LogicException('Message type not supported');
    }

    #[\Override]
    public function encode(Envelope $envelope): array
    {
        throw new \LogicException('Transport & serializer not meant for sending messages');
    }
}
