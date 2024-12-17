<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\User\Translator;

use EmpireDesAmis\BottleInventory\Domain\ValueObject\User;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\UserId;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\UserName;

final class UserTranslator
{
    public static function toUser(array $data): User
    {
        if ($data === []) {
            throw new \LogicException();
        }

        return User::create(
            UserId::fromString($data['email']),
            UserName::fromString('Hoge Hoge'),
            $data['isCurrent'],
        );
    }
}
