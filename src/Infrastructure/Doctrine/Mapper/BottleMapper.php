<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\Doctrine\Mapper;

use EmpireDesAmis\BottleInventory\Domain\Entity\Bottle;
use EmpireDesAmis\BottleInventory\Domain\Enum\Rate;
use EmpireDesAmis\BottleInventory\Domain\Enum\WineType;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleCountry;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleEstateName;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleGrapeVarieties;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleId;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleName;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleOwnerId;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottlePicture;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottlePrice;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleRate;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleSavedAt;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleTastedAt;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleWineType;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleYear;
use EmpireDesAmis\BottleInventory\Infrastructure\Doctrine\Entity\Bottle as BottleDoctrine;

final readonly class BottleMapper
{
    public static function toDomain(BottleDoctrine $bottle): Bottle
    {
        return new Bottle(
            BottleId::fromString($bottle->id),
            BottleName::fromString($bottle->name),
            BottleEstateName::fromString($bottle->estateName),
            BottleWineType::fromString($bottle->wineType->value),
            BottleYear::fromInt($bottle->year),
            BottleGrapeVarieties::fromArray($bottle->grapeVarieties),
            BottleRate::fromString($bottle->rate->value),
            BottleOwnerId::fromString($bottle->ownerId),
            $bottle->country ? BottleCountry::fromString($bottle->country) : null,
            $bottle->price ? BottlePrice::fromFloat($bottle->price) : null,
            BottleSavedAt::create($bottle->savedAt),
            $bottle->tastedAt
                ? BottleTastedAt::create($bottle->tastedAt)
                : null,
            $bottle->picture ? BottlePicture::fromString($bottle->picture) : null,
        );
    }

    public static function toInfrastructurePersist(Bottle $bottle): BottleDoctrine
    {
        return new BottleDoctrine(
            $bottle->id()->value(),
            $bottle->name()->value(),
            $bottle->estateName()->value(),
            WineType::from($bottle->wineType()->value()),
            $bottle->year()->value(),
            $bottle->grapeVarieties()->values(),
            Rate::from($bottle->rate()->value()),
            $bottle->ownerId()->value(),
            $bottle->savedAt()?->value() ?? new \DateTimeImmutable(),
            $bottle->country()?->value(),
            $bottle->price()?->amount(),
        );
    }

    public static function toInfrastructureUpdate(
        Bottle $bottle,
        BottleDoctrine $bottleDoctrine,
    ): BottleDoctrine {
        $bottleDoctrine->name = $bottle->name()->value();
        $bottleDoctrine->estateName = $bottle->estateName()->value();
        $bottleDoctrine->wineType = WineType::from($bottle->wineType()->value());
        $bottleDoctrine->year = $bottle->year()->value();
        $bottleDoctrine->grapeVarieties = $bottle->grapeVarieties()->values();
        $bottleDoctrine->rate = Rate::from($bottle->rate()->value());
        $bottleDoctrine->ownerId = $bottle->ownerId()->value();
        $bottleDoctrine->savedAt = $bottle->savedAt()?->value() ?? new \DateTimeImmutable();
        $bottleDoctrine->country = $bottle->country()?->value();
        $bottleDoctrine->price = $bottle->price()?->amount();
        $bottleDoctrine->tastedAt = $bottle->tastedAt()?->value();
        $bottleDoctrine->picture = $bottle->picture()?->path();

        return $bottleDoctrine;
    }
}
