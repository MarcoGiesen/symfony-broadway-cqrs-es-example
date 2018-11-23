<?php

namespace App\Domain\User\Command;

use App\Domain\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ChangeUserEmail implements CommandInterface
{
    /**
     * @var array
     *
     * @Assert\Collection(
     *     fields = {
     *         "uuid" = {
     *             @Assert\NotBlank
     *         },
     *         "email" = {
     *             @Assert\NotBlank,
     *             @Assert\Email
     *         }
     *     },
     *     allowMissingFields = true
     * )
     */
    private $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function getUuid(): string
    {
        return $this->payload['uuid'];
    }

    public function getEmail(): string
    {
        return $this->payload['email'];
    }
}
