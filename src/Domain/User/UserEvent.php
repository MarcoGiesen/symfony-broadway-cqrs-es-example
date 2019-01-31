<?php

namespace App\Domain\User;

use Broadway\Serializer\Serializable;

abstract class UserEvent implements Serializable
{
    private $userId;

    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function serialize(): array
    {
        return ['userId' => (string)$this->userId];
    }
}
