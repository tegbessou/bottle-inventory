<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use EmpireDesAmis\BottleInventory\Domain\Entity\GrapeVariety;
use EmpireDesAmis\BottleInventory\Domain\Repository\GrapeVarietyRepositoryInterface;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\GrapeVarietyName;

final readonly class GrapeVarietyDoctrineRepository implements GrapeVarietyRepositoryInterface
{
    private const string ENTITY_CLASS = GrapeVariety::class;
    private const string ALIAS = 'grape_variety';

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[\Override]
    public function exist(GrapeVarietyName $name): bool
    {
        return $this->entityManager->createQueryBuilder()
            ->select('1')
            ->from(self::ENTITY_CLASS, self::ALIAS)
            ->where(sprintf('%s.name.value = :name', self::ALIAS))
            ->setParameter('name', $name->value())
            ->getQuery()
            ->getOneOrNullResult() !== null;
    }
}
