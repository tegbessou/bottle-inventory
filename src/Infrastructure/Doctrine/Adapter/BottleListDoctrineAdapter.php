<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\Doctrine\Adapter;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Query\Builder;
use EmpireDesAmis\BottleInventory\Application\Adapter\BottleListAdapterInterface;
use EmpireDesAmis\BottleInventory\Application\ReadModel\BottleList;
use TegCorp\SharedKernelBundle\Infrastructure\Doctrine\ODM\DoctrineRepository;

/**
 * @extends DoctrineRepository<BottleList>
 */
final class BottleListDoctrineAdapter extends DoctrineRepository implements BottleListAdapterInterface
{
    private const string MODEL_CLASS = BottleList::class;

    public function __construct(
        protected DocumentManager $documentManager,
    ) {
        parent::__construct($documentManager, self::MODEL_CLASS);
    }

    #[\Override]
    public function ofId(string $id): ?BottleList
    {
        return $this->documentManager->find(self::MODEL_CLASS, $id);
    }

    #[\Override]
    public function sortName(): self
    {
        return $this->filter(static function (Builder $qb): void {
            $qb->sort('name', 'ASC');
        });
    }

    #[\Override]
    public function withName(string $name): self
    {
        return $this->filter(static function (Builder $qb) use ($name): void {
            $qb->field('name')->text($name);
        });
    }

    #[\Override]
    public function withEstateName(string $estateName): self
    {
        return $this->filter(static function (Builder $qb) use ($estateName): void {
            $qb->field('estateName')->text($estateName);
        });
    }

    #[\Override]
    public function withYear(int $year): self
    {
        return $this->filter(static function (Builder $qb) use ($year): void {
            $qb->field('year')->equals($year);
        });
    }

    #[\Override]
    public function withRate(string $rate): self
    {
        return $this->filter(static function (Builder $qb) use ($rate): void {
            $qb->field('rate')->equals($rate);
        });
    }

    #[\Override]
    public function savedAt(string $savedAt): self
    {
        return $this->filter(static function (Builder $qb) use ($savedAt): void {
            $qb->field('savedAt')->equals($savedAt);
        });
    }

    #[\Override]
    public function withWineType(string $wineType): self
    {
        return $this->filter(static function (Builder $qb) use ($wineType): void {
            $qb->field('wineType')->text($wineType);
        });
    }

    #[\Override]
    public function add(BottleList $bottle): void
    {
        $this->documentManager->persist($bottle);
        $this->documentManager->flush();
    }

    #[\Override]
    public function update(BottleList $bottle): void
    {
        $this->documentManager->flush();
    }

    #[\Override]
    public function delete(BottleList $bottle): void
    {
        $this->documentManager->remove($bottle);
        $this->documentManager->flush();
    }
}
