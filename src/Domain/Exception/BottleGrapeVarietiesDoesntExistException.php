<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\Exception;

final class BottleGrapeVarietiesDoesntExistException extends \Exception
{
    public function __construct(
        public array $grapeVarieties,
    ) {
        parent::__construct(sprintf('Grape varieties %s doesn\'t exist', implode(',', $grapeVarieties)));
    }
}
