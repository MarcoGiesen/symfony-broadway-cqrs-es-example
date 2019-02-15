<?php

namespace App\Domain\User\DomainEvent;

use App\Domain\User\UserEvent;
use App\Domain\User\UserId;

class UserPasswordWasChangedAnomaly extends UserEvent
{
    private $message;

    public function __construct(UserId $userId, string $message)
    {
        parent::__construct($userId);
        $this->message = $message;
    }

    public function password(): string
    {
        return $this->message;
    }

    public static function deserialize(array $data): self
    {
        return new self(
            new UserId($data['userId']),
            $data['message']
        );
    }

    public function serialize(): array
    {
        return array_merge(parent::serialize(), array(
            'message' => $this->message,
        ));
    }
}