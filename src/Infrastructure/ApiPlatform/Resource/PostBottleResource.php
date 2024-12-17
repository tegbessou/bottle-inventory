<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use EmpireDesAmis\BottleInventory\Domain\Enum\Rate;
use EmpireDesAmis\BottleInventory\Domain\Enum\WineType;
use EmpireDesAmis\BottleInventory\Infrastructure\ApiPlatform\State\Processor\CreateBottleProcessor;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Bottle',
)]
#[Post(
    uriTemplate: '/bottles',
    processor: CreateBottleProcessor::class,
)]
final readonly class PostBottleResource
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
        #[Assert\NotBlank]
        #[Assert\Email]
        public ?string $ownerId = null,
        #[ApiProperty]
        public ?string $country = null,
        #[ApiProperty]
        #[Assert\GreaterThanOrEqual(0.0)]
        public ?float $price = null,
    ) {
    }
}
