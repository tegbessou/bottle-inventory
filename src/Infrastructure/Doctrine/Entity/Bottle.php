<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use EmpireDesAmis\BottleInventory\Domain\Enum\Rate;
use EmpireDesAmis\BottleInventory\Domain\Enum\WineType;

#[ORM\Entity]
class Bottle
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(name: 'id', type: 'uuid', length: 36, unique: true)]
        public string $id,
        #[ORM\Column(name: 'name', type: 'string', length: 255)]
        public string $name,
        #[ORM\Column(name: 'estate_name', type: 'string', length: 255)]
        public string $estateName,
        #[ORM\Column(name: 'type', type: 'string', length: 255, enumType: WineType::class)]
        public WineType $wineType,
        #[ORM\Column(name: 'year', type: 'integer', length: 4)]
        public int $year,
        #[ORM\Column(name: 'grape_varieties', type: 'json')]
        public array $grapeVarieties,
        #[ORM\Column(name: 'rate', type: 'string', length: 2, enumType: Rate::class)]
        public Rate $rate,
        #[ORM\Column(name: 'owner_id', type: 'string')]
        public string $ownerId,
        #[ORM\Column(name: 'saved_at', type: 'date_immutable')]
        public \DateTimeImmutable $savedAt,
        #[ORM\Column(name: 'country', type: 'string', length: 255, nullable: true)]
        public ?string $country = null,
        #[ORM\Column(name: 'price', type: 'float', nullable: true)]
        public ?float $price = null,
        #[ORM\Column(name: 'tasted_at', type: 'date_immutable', nullable: true)]
        public ?\DateTimeImmutable $tastedAt = null,
        #[ORM\Column(name: 'picture', type: 'string', length: 255, nullable: true)]
        public ?string $picture = null,
    ) {}
}