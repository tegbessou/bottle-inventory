<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\Doctrine\Adapter;

use Doctrine\ODM\MongoDB\DocumentManager;
use EmpireDesAmis\BottleInventory\Application\Adapter\BottleAdapterInterface;
use EmpireDesAmis\BottleInventory\Application\ReadModel\Bottle;

final readonly class BottleDoctrineAdapter implements BottleAdapterInterface
{
    public function __construct(
        private DocumentManager $documentManager,
    ) {
    }

    #[\Override]
    public function ofId(string $id): ?Bottle
    {
        return $this->documentManager->find(Bottle::class, $id);
    }

    #[\Override]
    public function add(Bottle $bottle): void
    {
        $this->documentManager->persist($bottle);
        $this->documentManager->flush();
    }

    #[\Override]
    public function update(Bottle $bottle): void
    {
        $this->documentManager->flush();
    }

    #[\Override]
    public function delete(Bottle $bottle): void
    {
        $this->documentManager->remove($bottle);
        $this->documentManager->flush();
    }
}
