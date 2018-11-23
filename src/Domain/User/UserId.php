<?php

namespace App\Domain\User;

use Assert\Assertion as Assert;

class UserId
{
    private $userId;

    public function __construct(string $userId)
    {
        Assert::string($userId);
        Assert::uuid($userId);

        $this->userId = $userId;
    }

    public function __toString(): string
    {
        return $this->userId;
    }
}
