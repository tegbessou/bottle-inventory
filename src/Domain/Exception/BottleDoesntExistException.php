<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\Exception;

final class BottleDoesntExistException extends \Exception
{
    public function __construct(
        public readonly string $bottleId,
    ) {
        parent::__construct(sprintf('BottleInventory %s does not exist', $this->bottleId));
    }
}
