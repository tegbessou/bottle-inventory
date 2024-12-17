<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use EmpireDesAmis\BottleInventory\Application\Command\TasteBottleCommand;
use EmpireDesAmis\BottleInventory\Domain\Exception\BottleDoesntExistException;
use EmpireDesAmis\BottleInventory\Domain\Exception\TasteBottleNotAuthorizeForThisUserException;
use EmpireDesAmis\BottleInventory\Infrastructure\ApiPlatform\Resource\TasteBottleResource;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TegCorp\SharedKernelBundle\Application\Command\CommandBusInterface;
use TegCorp\SharedKernelBundle\Infrastructure\Webmozart\Assert;

/**
 * @implements ProcessorInterface<TasteBottleResource, void>
 */
#[WithMonologChannel('bottle_inventory')]
final readonly class TasteBottleProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private LoggerInterface $logger,
    ) {
    }

    #[\Override]
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        Assert::isInstanceOf($data, TasteBottleResource::class);
        Assert::notNull($uriVariables['id']);
        Assert::uuid($uriVariables['id']);

        try {
            $this->commandBus->dispatch(
                new TasteBottleCommand($uriVariables['id'])
            );
        } catch (BottleDoesntExistException $exception) {
            $this->logger->error(
                'Taste bottle: Bottle doesn\'t exist found',
                [
                    'bottleId' => $exception->bottleId,
                ],
            );

            throw new NotFoundHttpException();
        } catch (TasteBottleNotAuthorizeForThisUserException) {
            $this->logger->error(
                'Taste bottle: User not authorized to taste this bottle',
            );

            throw new AccessDeniedHttpException();
        }
    }
}
