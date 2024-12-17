<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\Exception;

final class UpdateBottleDoesntExistException extends \Exception
{
    public function __construct(
        public string $bottleId,
    ) {
        parent::__construct();
    }
}
