<?php

namespace App\Domain\User\Aggregate;

use App\Domain\User\DomainEvent\UserEmailWasChanged;
use App\Domain\User\DomainEvent\UserPasswordWasChanged;
use App\Domain\User\DomainEvent\UserPasswordWasChangedAnomaly;
use App\Domain\User\DomainEvent\UserWasRegistered;
use App\Domain\User\UserId;
use Broadway\EventSourcing\EventSourcedAggregateRoot;

class User extends EventSourcedAggregateRoot
{
    private $userId;
    private $username;
    private $email;
    private $password;

    /**
     * @return string
     */
    public function getAggregateRootId(): string
    {
        return $this->userId;
    }

    public static function registerUser(UserId $userId, string $username, string $email, string $password): User
    {
        $user = new self();
        $user->register($userId, $username, $email, $password);

        return $user;
    }

    private function register(UserId $userId, string $username, string $email, string $password): void
    {
        $this->apply(
            new UserWasRegistered(
                $userId,
                $username,
                $email,
                $password
            )
        );
    }

    public function changeEmail(UserId $userId, string $email): void
    {
        $this->apply(
            new UserEmailWasChanged(
                $userId,
                $email
            )
        );
    }

    public function changePassword(UserId $userId, string $password): void
    {
        if ($this->password !== $password) {
            $this->apply(
                new UserPasswordWasChangedAnomaly(
                    $userId,
                    'Wrong password given, password change was denied.'
                )
            );

            return;
        }

        $this->apply(
            new UserPasswordWasChanged(
                $userId,
                $password
            )
        );
    }

    public function applyUserWasRegistered(UserWasRegistered $userWasRegistered): void
    {
        $this->userId = $userWasRegistered->userId();
        $this->username = $userWasRegistered->username();
        $this->email = $userWasRegistered->email();
        $this->password = $userWasRegistered->password();
    }

    public function applyUserEmailWasChanged(UserEmailWasChanged $userEmailWasChanged): void
    {
        $this->email = $userEmailWasChanged->email();
    }

    public function applyUserPasswordWasChanged(UserPasswordWasChanged $userPasswordWasChanged): void
    {
        $this->password = $userPasswordWasChanged->password();
    }
}
