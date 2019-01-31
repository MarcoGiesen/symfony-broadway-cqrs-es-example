<?php

namespace App\Domain\User\DomainEvent;

use App\Domain\User\UserEvent;
use App\Domain\User\UserId;

class UserPasswordWasChanged extends UserEvent
{
    private $password;

    public function __construct(UserId $userId, string $password)
    {
        parent::__construct($userId);
        $this->password = $password;
    }

    public function password(): string
    {
        return $this->password;
    }

    public static function deserialize(array $data): self
    {
        return new self(
            new UserId($data['userId']),
            $data['password']
        );
    }

    public function serialize(): array
    {
        return array_merge(parent::serialize(), array(
            'password' => $this->password,
        ));
    }
}