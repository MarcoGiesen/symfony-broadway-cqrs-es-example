<?php

namespace App\Domain\User\DomainEvent;

use App\Domain\User\UserEvent;
use App\Domain\User\UserId;

class UserEmailWasChanged extends UserEvent
{
    private $email;

    public function __construct(UserId $userId, string $email)
    {
        parent::__construct($userId);
        $this->email = $email;
    }

    public function email(): string
    {
        return $this->email;
    }

    public static function deserialize(array $data): self
    {
        return new self(
            new UserId($data['userId']),
            $data['email']
        );
    }

    public function serialize(): array
    {
        return array_merge(parent::serialize(), array(
            'email' => $this->email,
        ));
    }
}