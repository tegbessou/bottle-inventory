<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use EmpireDesAmis\BottleInventory\Domain\Entity\Bottle;
use EmpireDesAmis\BottleInventory\Domain\Repository\BottleRepositoryInterface;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleId;
use EmpireDesAmis\BottleInventory\Infrastructure\Doctrine\Entity\Bottle as BottleDoctrine;
use EmpireDesAmis\BottleInventory\Infrastructure\Doctrine\Mapper\BottleMapper;

final readonly class BottleDoctrineRepository implements BottleRepositoryInterface
{
    private const string ENTITY_CLASS = BottleDoctrine::class;

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[\Override]
    public function ofId(BottleId $bottleId): ?Bottle
    {
        $bottleDoctrine = $this->entityManager->find(self::ENTITY_CLASS, $bottleId->value());

        if ($bottleDoctrine === null) {
            return null;
        }

        return BottleMapper::toDomain($bottleDoctrine);
    }

    #[\Override]
    public function add(Bottle $bottle): void
    {
        $bottleToDoctrine = BottleMapper::toInfrastructurePersist($bottle);

        $this->entityManager->persist($bottleToDoctrine);
        $this->entityManager->flush();
    }

    #[\Override]
    public function update(Bottle $bottle): void
    {
        $bottleOrm = $this->entityManager->getRepository(self::ENTITY_CLASS)->find(
            $bottle->id()->value(),
        );

        if ($bottleOrm === null) {
            throw new \LogicException('BottleDoctrineRepository Bottle must exist in doctrine.');
        }

        BottleMapper::toInfrastructureUpdate($bottle, $bottleOrm);

        $this->entityManager->flush();
    }

    #[\Override]
    public function delete(Bottle $bottle): void
    {
        $bottleOrm = $this->entityManager->getRepository(self::ENTITY_CLASS)->find(
            $bottle->id()->value(),
        );

        if ($bottleOrm === null) {
            throw new \LogicException('BottleDoctrineRepository Bottle must exist in doctrine.');
        }

        $this->entityManager->remove($bottleOrm);
        $this->entityManager->flush();
    }
}
