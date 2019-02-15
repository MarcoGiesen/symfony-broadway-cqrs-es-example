<?php

namespace App\Domain\User\DomainEvent;

use App\Domain\User\UserEvent;
use App\Domain\User\UserId;

class UserWasRegistered extends UserEvent
{
    private $username;
    private $email;
    private $password;

    public function __construct(UserId $userId, string $username, string $email, string $password)
    {
        parent::__construct($userId);
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public static function deserialize(array $data): self
    {
        return new self(
            new UserId($data['userId']),
            $data['username'],
            $data['email'],
            $data['password']
        );
    }

    public function serialize(): array
    {
        return array_merge(parent::serialize(), array(
            'username'   => $this->username,
            'email' => $this->email,
            'password' => $this->password,
        ));
    }
}
