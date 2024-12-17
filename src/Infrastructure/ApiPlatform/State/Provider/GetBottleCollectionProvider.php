<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\ProviderInterface;
use EmpireDesAmis\BottleInventory\Application\Query\GetBottlesQuery;
use EmpireDesAmis\BottleInventory\Domain\Enum\Rate;
use EmpireDesAmis\BottleInventory\Domain\Enum\WineType;
use EmpireDesAmis\BottleInventory\Infrastructure\ApiPlatform\Resource\GetCollectionBottleResource;
use TegCorp\SharedKernelBundle\Application\Query\QueryBusInterface;
use TegCorp\SharedKernelBundle\Infrastructure\ApiPlatform\State\Pagination\Paginator;

/**
 * @implements ProviderInterface<GetCollectionBottleResource>
 */
final readonly class GetBottleCollectionProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private Pagination $pagination,
    ) {
    }

    /**
     * @return Paginator<GetCollectionBottleResource>|list<GetCollectionBottleResource>
     */
    #[\Override]
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): Paginator|array
    {
        $name = $context['filters']['name'] ?? null;
        $estateName = $context['filters']['estateName'] ?? null;
        $type = isset($context['filters']['type']) ? WineType::from($context['filters']['type']) : null;
        $savedAt = $context['filters']['savedAt'] ?? null;
        $year = isset($context['filters']['year']) ? (int) $context['filters']['year'] : null;
        $rate = isset($context['filters']['rate']) ? Rate::from($context['filters']['rate']) : null;
        $page = $limit = 0;

        if ($this->pagination->isEnabled($operation)) {
            $page = $this->pagination->getPage($context);
            $limit = $this->pagination->getLimit($operation, $context);
        }

        $models = $this->queryBus->ask(new GetBottlesQuery(
            $name,
            $estateName,
            $type?->value,
            $savedAt,
            $year,
            $rate?->value,
            $page,
            $limit
        ));

        $resources = [];

        foreach ($models as $model) {
            $resources[] = GetCollectionBottleResource::fromModel($model);
        }

        if (null !== $paginator = $models->paginator()) {
            $resources = new Paginator(
                new \ArrayIterator($resources),
                (float) $paginator->getCurrentPage(),
                (float) $paginator->getItemsPerPage(),
                (float) $paginator->getLastPage(),
                (float) $paginator->getTotalItems(),
            );
        }

        return $resources;
    }
}
