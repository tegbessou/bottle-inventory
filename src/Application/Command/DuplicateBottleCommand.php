<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Command;

use TegCorp\SharedKernelBundle\Application\Command\CommandInterface;

/**
 * @implements CommandInterface<void>
 */
final readonly class DuplicateBottleCommand implements CommandInterface
{
    public function __construct(
        public string $bottleId,
        public string $newOwner,
    ) {
    }
}
