<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\Adapter;

use EmpireDesAmis\BottleInventory\Domain\ValueObject\User;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\UserId;

interface UserAdapterInterface
{
    public function ofId(UserId $email): ?User;
}
