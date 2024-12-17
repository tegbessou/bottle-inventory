<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Exception;

final class BottleDoesntExistException extends \LogicException
{
    public function __construct(
        public readonly string $bottleId,
    ) {
        parent::__construct(sprintf('Bottle %s does not exist', $this->bottleId));
    }
}
