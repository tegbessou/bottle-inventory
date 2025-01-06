<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\Symfony\Messenger\MessageHandler;

use EmpireDesAmis\BottleInventory\Application\Command\DuplicateBottleCommand;
use EmpireDesAmis\BottleInventory\Domain\Exception\BottleDoesntExistException;
use EmpireDesAmis\BottleInventory\Infrastructure\Symfony\Messenger\ExternalMessage\CreateBottleForParticipantWhenInvitationIsAcceptedMessage;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use TegCorp\SharedKernelBundle\Application\Command\CommandBusInterface;

#[AsMessageHandler]
#[WithMonologChannel('bottle_inventory')]
final readonly class DuplicateBottleMessageHandler
{
    public function __construct(
        private CommandBusInterface $bus,
        private LoggerInterface $logger,
    ) {
    }

    public function __invoke(CreateBottleForParticipantWhenInvitationIsAcceptedMessage $message): void
    {
        try {
            $this->bus->dispatch(
                new DuplicateBottleCommand(
                    $message->bottleId,
                    $message->participant,
                ),
            );
        } catch (BottleDoesntExistException $exception) {
            $this->logger->error(
                'Duplicate bottle: Bottle to duplicate doesn\'t exist.',
                [
                    'bottleId' => $exception->bottleId,
                ],
            );

            throw new UnrecoverableMessageHandlingException();
        }
    }
}
