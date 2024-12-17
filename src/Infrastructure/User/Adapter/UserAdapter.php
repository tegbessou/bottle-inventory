<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\User\Adapter;

use EmpireDesAmis\BottleInventory\Domain\Adapter\UserAdapterInterface;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\User;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\UserId;
use EmpireDesAmis\BottleInventory\Infrastructure\User\Repository\UserRepositoryInterface;
use EmpireDesAmis\BottleInventory\Infrastructure\User\Translator\UserTranslator;

final readonly class UserAdapter implements UserAdapterInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    #[\Override]
    public function ofId(UserId $email): ?User
    {
        try {
            return UserTranslator::toUser(
                $this->userRepository->ofEmail($email->value())
            );
        } catch (\LogicException) {
            return null;
        }
    }
}
