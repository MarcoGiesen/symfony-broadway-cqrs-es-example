<?php

namespace App\Domain\User\DomainEvent;

use App\Domain\User\UserEvent;
use App\Domain\User\UserId;

class UserWasRegistered extends UserEvent
{
    private $username;
    private $email;

    public function __construct(UserId $userId, string $username, string $email)
    {
        parent::__construct($userId);
        $this->username = $username;
        $this->email = $email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public static function deserialize(array $data): self
    {
        return new self(
            new UserId($data['userId']),
            $data['username'],
            $data['email']
        );
    }

    public function serialize(): array
    {
        return array_merge(parent::serialize(), array(
            'username'   => $this->username,
            'email' => $this->email,
        ));
    }
}