<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\ValueObject;

final readonly class User
{
    public function __construct(
        private UserId $id,
        private UserName $name,
        private bool $currentUser,
    ) {
    }

    public static function create(
        UserId $email,
        UserName $name,
        bool $isCurrentEmail,
    ): self {
        return new self(
            $email,
            $name,
            $isCurrentEmail,
        );
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function name(): UserName
    {
        return $this->name;
    }

    public function isCurrentUser(): bool
    {
        return $this->currentUser;
    }
}
