<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\Entity;

use EmpireDesAmis\BottleInventory\Domain\Event\BottleCreated;
use EmpireDesAmis\BottleInventory\Domain\Event\BottleDeleted;
use EmpireDesAmis\BottleInventory\Domain\Event\BottleDuplicated;
use EmpireDesAmis\BottleInventory\Domain\Event\BottlePictureAdded;
use EmpireDesAmis\BottleInventory\Domain\Event\BottleTasted;
use EmpireDesAmis\BottleInventory\Domain\Event\BottleUpdated;
use EmpireDesAmis\BottleInventory\Domain\Exception\BottleAddPicturePictureCannotBeNullException;
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
use TegCorp\SharedKernelBundle\Domain\Entity\EntityDomainEventTrait;
use TegCorp\SharedKernelBundle\Domain\Entity\EntityWithDomainEventInterface;

final class Bottle implements EntityWithDomainEventInterface
{
    use EntityDomainEventTrait;

    public function __construct(
        private BottleId $id,
        private BottleName $name,
        private BottleEstateName $estateName,
        private BottleWineType $wineType,
        private BottleYear $year,
        private BottleGrapeVarieties $grapeVarieties,
        private BottleRate $rate,
        private BottleOwnerId $ownerId,
        private ?BottleCountry $country = null,
        private ?BottlePrice $price = null,
        private ?BottleSavedAt $savedAt = null,
        private ?BottleTastedAt $tastedAt = null,
        private ?BottlePicture $picture = null,
    ) {
    }

    public static function create(
        BottleId $id,
        BottleName $name,
        BottleEstateName $estateName,
        BottleWineType $wineType,
        BottleYear $year,
        BottleGrapeVarieties $grapeVarieties,
        BottleRate $rate,
        BottleOwnerId $ownerId,
        ?BottleCountry $country = null,
        ?BottlePrice $price = null,
    ): self {
        $bottle = new self(
            $id,
            $name,
            $estateName,
            $wineType,
            $year,
            $grapeVarieties,
            $rate,
            $ownerId,
            $country,
            $price,
            BottleSavedAt::create(),
        );

        self::recordEvent(
            new BottleCreated(
                $bottle->id->value(),
                $bottle->name->value(),
                $bottle->estateName->value(),
                $bottle->wineType->value(),
                $bottle->year->value(),
                $bottle->rate->value(),
                $bottle->grapeVarieties->values(),
                $bottle->ownerId->value(),
                $bottle->savedAt?->dateUs() ?? (new \DateTime())->format('Y-m-d'),
                $bottle->country?->value() ?? null,
                $bottle->price?->amount() ?? null,
            ),
        );

        return $bottle;
    }

    public function addPicture(BottlePicture $picture): Bottle
    {
        $this->picture = $picture;

        $picture = $this->picture;

        if ($picture->path() === null) {
            throw new BottleAddPicturePictureCannotBeNullException();
        }

        self::recordEvent(
            new BottlePictureAdded(
                $this->id->value(),
                $picture->path(),
            )
        );

        return $this;
    }

    public function taste(): Bottle
    {
        $this->tastedAt = BottleTastedAt::create(
            new \DateTimeImmutable(),
        );

        self::recordEvent(
            new BottleTasted(
                $this->id->value(),
                $this->name->value(),
                $this->wineType->value(),
                $this->ownerId->value(),
                $this->tastedAt->dateUs(),
            )
        );

        return $this;
    }

    public function delete(): void
    {
        self::recordEvent(
            new BottleDeleted(
                $this->id->value(),
            )
        );
    }

    public function update(
        BottleName $name,
        BottleEstateName $estateName,
        BottleWineType $wineType,
        BottleYear $year,
        BottleGrapeVarieties $grapeVarieties,
        BottleRate $rate,
        ?BottleCountry $country = null,
        ?BottlePrice $price = null,
    ): void {
        $this->name = $name;
        $this->estateName = $estateName;
        $this->wineType = $wineType;
        $this->year = $year;
        $this->grapeVarieties = $grapeVarieties;
        $this->rate = $rate;
        $this->country = $country;
        $this->price = $price;

        self::recordEvent(
            new BottleUpdated(
                $this->id->value(),
                $this->name->value(),
                $this->estateName->value(),
                $this->wineType->value(),
                $this->year->value(),
                $this->grapeVarieties->values(),
                $this->rate->value(),
                $this->country?->value() ?? null,
                $this->price?->amount() ?? null,
            )
        );
    }

    public function duplicate(
        BottleId $id,
        BottleOwnerId $ownerId,
    ): Bottle {
        $duplicateBottle = self::create(
            $id,
            $this->name,
            $this->estateName,
            $this->wineType,
            $this->year,
            $this->grapeVarieties,
            $this->rate,
            $ownerId,
            $this->country,
            $this->price,
        );

        self::recordEvent(
            new BottleDuplicated(
                $duplicateBottle->id()->value(),
            ),
        );

        return $duplicateBottle;
    }

    public function id(): BottleId
    {
        return $this->id;
    }

    public function name(): BottleName
    {
        return $this->name;
    }

    public function estateName(): BottleEstateName
    {
        return $this->estateName;
    }

    public function wineType(): BottleWineType
    {
        return $this->wineType;
    }

    public function year(): BottleYear
    {
        return $this->year;
    }

    public function grapeVarieties(): BottleGrapeVarieties
    {
        return $this->grapeVarieties;
    }

    public function rate(): BottleRate
    {
        return $this->rate;
    }

    public function picture(): ?BottlePicture
    {
        return $this->picture;
    }

    public function ownerId(): BottleOwnerId
    {
        return $this->ownerId;
    }

    public function country(): ?BottleCountry
    {
        return $this->country;
    }

    public function price(): ?BottlePrice
    {
        return $this->price;
    }

    public function savedAt(): ?BottleSavedAt
    {
        return $this->savedAt;
    }

    public function tastedAt(): ?BottleTastedAt
    {
        return $this->tastedAt;
    }
}
