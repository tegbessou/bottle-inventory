<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\User\Repository;

final readonly class UserFakeRepository implements UserRepositoryInterface
{
    #[\Override]
    public function ofEmail(string $email): array
    {
        if ($email === 'hugues.gobet@gmail.com') {
            return [
                'email' => 'hugues.gobet@gmail.com',
                'isCurrent' => true,
            ];
        }

        if ($email === 'root@gmail.com') {
            return [
                'email' => 'root@gmail.com',
                'isCurrent' => false,
            ];
        }

        if ($email === 'new@gmail.com') {
            return [
                'email' => 'new@gmail.com',
                'isCurrent' => true,
            ];
        }

        return [];
    }
}
