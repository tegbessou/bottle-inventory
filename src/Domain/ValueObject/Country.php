<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\ValueObject;

final readonly class Country
{
    public function __construct(
        private CountryName $name,
    ) {
    }

    public static function create(CountryName $name): self
    {
        return new self($name);
    }

    public function name(): CountryName
    {
        return $this->name;
    }
}
