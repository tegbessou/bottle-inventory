<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Application\Exception;

final class OwnerDoesntExistException extends \Exception
{
    public function __construct(string $ownerId)
    {
        parent::__construct(sprintf('Owner with email %s doesn\'t exist', $ownerId));
    }
}
