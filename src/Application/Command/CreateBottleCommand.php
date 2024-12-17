<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Command;

use EmpireDesAmis\BottleInventory\Domain\ValueObject\BottleId;
use TegCorp\SharedKernelBundle\Application\Command\CommandInterface;

/**
 * @implements CommandInterface<BottleId>
 */
final readonly class CreateBottleCommand implements CommandInterface
{
    public function __construct(
        public string $name,
        public string $estateName,
        public string $type,
        public int $year,
        public array $grapeVarieties,
        public string $rate,
        public string $ownerId,
        public ?string $country,
        public ?float $price,
    ) {
    }
}
