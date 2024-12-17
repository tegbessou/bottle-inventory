<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\Exception;

final class BottleCountryDoesntExistException extends \Exception
{
    public function __construct(
        public readonly string $country,
    ) {
        parent::__construct(sprintf('Country %s does not exist', $this->country));
    }
}
