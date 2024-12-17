<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use EmpireDesAmis\BottleInventory\Domain\Entity\Bottle;
use EmpireDesAmis\BottleInventory\Domain\Repository\BottleRepositoryInterface;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleId;
use Symfony\Component\Uid\Uuid;

final readonly class BottleDoctrineRepository implements BottleRepositoryInterface
{
    private const string ENTITY_CLASS = Bottle::class;

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[\Override]
    public function ofId(BottleId $bottleId): ?Bottle
    {
        return $this->entityManager->find(self::ENTITY_CLASS, $bottleId->value());
    }

    #[\Override]
    public function add(Bottle $bottle): void
    {
        $this->entityManager->persist($bottle);
        $this->entityManager->flush();
    }

    #[\Override]
    public function nextIdentity(): BottleId
    {
        return BottleId::fromString(
            Uuid::v4()->toRfc4122()
        );
    }

    #[\Override]
    public function update(Bottle $bottle): void
    {
        $this->entityManager->flush();
    }

    #[\Override]
    public function delete(Bottle $bottle): void
    {
        $this->entityManager->remove($bottle);
        $this->entityManager->flush();
    }
}
