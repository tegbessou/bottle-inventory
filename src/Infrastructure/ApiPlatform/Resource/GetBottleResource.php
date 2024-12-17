<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use EmpireDesAmis\BottleInventory\Application\ReadModel\Bottle;
use EmpireDesAmis\BottleInventory\Domain\Enum\Rate;
use EmpireDesAmis\BottleInventory\Domain\Enum\WineType;
use EmpireDesAmis\BottleInventory\Infrastructure\ApiPlatform\State\Provider\GetBottleProvider;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Uid\Uuid;

#[ApiResource(
    shortName: 'Bottle',
)]
#[Get(
    uriTemplate: '/bottles/{id}',
    provider: GetBottleProvider::class,
)]
final readonly class GetBottleResource
{
    public function __construct(
        #[ApiProperty(identifier: true)]
        public ?AbstractUid $id = null,
        #[ApiProperty]
        public ?string $name = null,
        #[ApiProperty]
        public ?string $estateName = null,
        #[ApiProperty]
        public ?WineType $wineType = null,
        #[ApiProperty]
        public ?int $year = null,
        #[ApiProperty]
        public ?array $grapeVarieties = null,
        #[ApiProperty]
        public ?Rate $rate = null,
        #[ApiProperty]
        public ?string $ownerId = null,
        #[ApiProperty]
        public ?string $ownerName = null,
        #[ApiProperty]
        public ?string $country = null,
        #[ApiProperty]
        public ?float $price = null,
        #[ApiProperty]
        public ?string $picturePath = null,
        #[ApiProperty]
        public ?\DateTime $savedAt = null,
        #[ApiProperty]
        public ?\DateTime $tastedAt = null,
    ) {
    }

    public static function fromModel(Bottle $bottle): self
    {
        return new self(
            new Uuid($bottle->id),
            $bottle->name,
            $bottle->estateName,
            WineType::from($bottle->wineType),
            $bottle->year,
            $bottle->grapeVarieties,
            Rate::from($bottle->rate),
            $bottle->ownerId,
            $bottle->ownerName,
            $bottle->country ?? null,
            $bottle->price ?? null,
            picturePath: $bottle->picture ?? null,
            savedAt: new \DateTime($bottle->savedAt),
            tastedAt: $bottle->tastedAt !== null ? new \DateTime($bottle->tastedAt) : null,
        );
    }
}
