<?php

namespace App\Domain\User\Aggregate;

use App\Domain\User\DomainEvent\UserEmailWasChanged;
use App\Domain\User\DomainEvent\UserWasRegistered;
use App\Domain\User\UserId;
use Broadway\EventSourcing\EventSourcedAggregateRoot;

class User extends EventSourcedAggregateRoot
{
    private $userId;
    private $username;
    private $email;

    /**
     * @return string
     */
    public function getAggregateRootId(): string
    {
        return $this->userId;
    }

    public static function registerUser(UserId $userId, string $username, $email): User
    {
        $user = new self();
        $user->register($userId, $username, $email);

        return $user;
    }

    private function register(UserId $userId, string $username, $email): void
    {
        $this->apply(
            new UserWasRegistered(
                $userId,
                $username,
                $email
            )
        );
    }

    public function applyUserWasRegistered(UserWasRegistered $userWasRegistered): void
    {
        $this->userId = $userWasRegistered->getUserId();
        $this->username = $userWasRegistered->getUsername();
        $this->email = $userWasRegistered->getEmail();
    }

    public function changeEmail(UserId $userId, string $email): void
    {
        $this->apply(
            new UserWasRegistered(
                $userId,
                $email
            )
        );
    }

    public function applyUserEmailWasChanged(UserEmailWasChanged $userEmailWasChanged): void
    {
        $this->email = $userEmailWasChanged->getEmail();
    }
}
