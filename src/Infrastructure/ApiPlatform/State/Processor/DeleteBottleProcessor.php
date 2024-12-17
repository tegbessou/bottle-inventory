<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use EmpireDesAmis\BottleInventory\Application\Command\DeleteBottleCommand;
use EmpireDesAmis\BottleInventory\Domain\Exception\BottleDoesntExistException;
use EmpireDesAmis\BottleInventory\Domain\Exception\DeleteBottleNotAuthorizeForThisUserException;
use EmpireDesAmis\BottleInventory\Infrastructure\ApiPlatform\Resource\GetBottleResource;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TegCorp\SharedKernelBundle\Application\Command\CommandBusInterface;
use TegCorp\SharedKernelBundle\Infrastructure\Webmozart\Assert;

/**
 * @implements ProcessorInterface<GetBottleResource, void>
 */
#[WithMonologChannel('bottle_inventory')]
final readonly class DeleteBottleProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private LoggerInterface $logger,
    ) {
    }

    #[\Override]
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        Assert::notNull($uriVariables['id']);
        Assert::uuid($uriVariables['id']);

        try {
            $this->commandBus->dispatch(
                new DeleteBottleCommand($uriVariables['id'])
            );
        } catch (BottleDoesntExistException $exception) {
            $this->logger->error(
                'Delete bottle: Bottle doesn\'t exist found',
                [
                    'bottleId' => $exception->bottleId,
                ],
            );

            throw new NotFoundHttpException();
        } catch (DeleteBottleNotAuthorizeForThisUserException) {
            $this->logger->error(
                'Delete bottle: User not authorized to delete this bottle',
            );

            throw new AccessDeniedHttpException();
        }
    }
}
