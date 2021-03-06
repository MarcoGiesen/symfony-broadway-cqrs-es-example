<?php

namespace App\Domain\User\Command;

use App\Domain\User\CreateUserCommand;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterUser extends CreateUserCommand
{
    /**
     * @var array
     *
     * @Assert\Collection(
     *     fields = {
     *         "email" = {
     *             @Assert\Email,
     *             @Assert\NotBlank
     *         },
     *         "username" = {
     *             @Assert\NotBlank,
     *             @Assert\Length(min=3)
     *         },
     *         "password" = {
     *             @Assert\NotBlank,
     *             @Assert\Length(min=3)
     *         }
     *     }
     * )
     */
    private $payload;

    public function __construct(array $payload)
    {
        parent::__construct();
        $this->payload = $payload;
    }

    public function username(): string
    {
        return $this->payload['username'];
    }

    public function email(): string
    {
        return $this->payload['email'];
    }

    public function password(): string
    {
        return $this->payload['password'];
    }
}
