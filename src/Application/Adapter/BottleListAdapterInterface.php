<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Adapter;

use EmpireDesAmis\BottleInventory\Application\ReadModel\BottleList;
use TegCorp\SharedKernelBundle\Domain\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<BottleList>
 */
interface BottleListAdapterInterface extends RepositoryInterface
{
    public function ofId(string $id): ?BottleList;

    public function sortName(): self;

    public function withName(string $name): self;

    public function withEstateName(string $estateName): self;

    public function withYear(int $year): self;

    public function withRate(string $rate): self;

    public function savedAt(string $savedAt): self;

    public function withWineType(string $wineType): self;

    public function add(BottleList $bottle): void;

    public function update(BottleList $bottle): void;

    public function delete(BottleList $bottle): void;
}
