<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use EmpireDesAmis\BottleInventory\Application\Query\GetBottleQuery;
use EmpireDesAmis\BottleInventory\Infrastructure\ApiPlatform\Resource\GetBottleResource;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TegCorp\SharedKernelBundle\Application\Query\QueryBusInterface;

/**
 * @implements ProviderInterface<GetBottleResource>
 */
#[WithMonologChannel('bottle_inventory')]
final readonly class GetBottleProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private LoggerInterface $logger,
    ) {
    }

    #[\Override]
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): GetBottleResource
    {
        $bottle = $this->queryBus->ask(new GetBottleQuery($uriVariables['id']));

        if ($bottle === null) {
            $this->logger->error(
                'Get bottle: Bottle not found',
                [
                    'bottleId' => $uriVariables['id'],
                ],
            );

            throw new NotFoundHttpException();
        }

        return GetBottleResource::fromModel($bottle);
    }
}
