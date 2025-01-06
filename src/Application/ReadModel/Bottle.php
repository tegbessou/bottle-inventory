<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\ReadModel;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document]
class Bottle
{
    public function __construct(
        #[MongoDB\Id(strategy: 'UUID')]
        public string $id,
        #[MongoDB\Field(type: 'string')]
        public string $name,
        #[MongoDB\Field(type: 'string')]
        public string $estateName,
        #[MongoDB\Field(type: 'string')]
        public string $rate,
        #[MongoDB\Field(type: 'int')]
        public int $year,
        #[MongoDB\Field(type: 'string')]
        public string $wineType,
        #[MongoDB\Field(type: 'string')]
        public string $savedAt,
        #[MongoDB\Field(type: 'hash')]
        /** @var string[] $grapeVarieties */
        public array $grapeVarieties,
        #[MongoDB\Field(type: 'string')]
        public string $ownerId,
        #[MongoDB\Field(type: 'string')]
        public string $ownerName,
        #[MongoDB\Field(type: 'string', nullable: true)]
        public ?string $country = null,
        #[MongoDB\Field(type: 'float', nullable: true)]
        public ?float $price = null,
        #[MongoDB\Field(type: 'string', nullable: true)]
        public ?string $picture = null,
        #[MongoDB\Field(type: 'string', nullable: true)]
        public ?string $tastedAt = null,
    ) {
    }
}
