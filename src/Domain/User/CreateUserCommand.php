<?php

namespace App\Domain\User;

use App\Domain\CommandInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

abstract class CreateUserCommand implements CommandInterface
{
    /**
     * @var UserId
     *
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    private $userId;

    public function __construct()
    {
        $this->userId = new UserId(Uuid::uuid4()->toString());
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }
}