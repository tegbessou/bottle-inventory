<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Put;
use EmpireDesAmis\BottleInventory\Application\ReadModel\Bottle;
use EmpireDesAmis\BottleInventory\Domain\Enum\Rate;
use EmpireDesAmis\BottleInventory\Domain\Enum\WineType;
use EmpireDesAmis\BottleInventory\Infrastructure\ApiPlatform\State\Processor\PutBottleProcessor;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Bottle',
)]
#[Put(
    uriTemplate: '/bottles/{id}',
    read: false,
    processor: PutBottleProcessor::class,
)]
final readonly class PutBottleResource
{
    public function __construct(
        #[ApiProperty]
        #[Assert\NotBlank]
        public ?string $name = null,
        #[ApiProperty]
        #[Assert\NotBlank]
        public ?string $estateName = null,
        #[ApiProperty]
        #[Assert\NotBlank]
        #[Assert\Type(type: WineType::class)]
        public ?WineType $wineType = null,
        #[ApiProperty]
        #[Assert\NotBlank]
        #[Assert\LessThanOrEqual(2100)]
        #[Assert\GreaterThanOrEqual(1800)]
        public ?int $year = null,
        #[ApiProperty]
        #[Assert\NotBlank]
        public ?array $grapeVarieties = null,
        #[ApiProperty]
        #[Assert\NotBlank]
        #[Assert\Type(type: Rate::class)]
        public ?Rate $rate = null,
        #[ApiProperty]
        public ?string $country = null,
        #[ApiProperty]
        #[Assert\GreaterThanOrEqual(0.0)]
        public ?float $price = null,
    ) {
    }

    public static function fromModel(Bottle $bottle): self
    {
        return new self(
            $bottle->name,
            $bottle->estateName,
            WineType::from($bottle->wineType),
            $bottle->year,
            $bottle->grapeVarieties,
            Rate::from($bottle->rate),
            $bottle->country ?? null,
            $bottle->price ?? null,
        );
    }
}
