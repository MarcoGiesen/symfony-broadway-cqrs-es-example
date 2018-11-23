<?php

namespace App\Domain\User\Command;

use App\Domain\CommandInterface;
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
     *         }
     *     },
     *     allowMissingFields = true
     * )
     */
    private $payload;

    public function __construct(array $payload)
    {
        parent::__construct();
        $this->payload = $payload;
    }

    public function getUsername(): string
    {
        return $this->payload['username'];
    }

    public function getEmail(): string
    {
        return $this->payload['email'];
    }
}
