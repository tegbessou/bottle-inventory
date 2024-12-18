<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class GrapeVariety
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(name: 'id', type: 'uuid', length: 36, unique: true)]
        public string $id,
        #[ORM\Column(name: 'name', type: 'string', length: 255, unique: true)]
        public string $name,
    ) {}
}