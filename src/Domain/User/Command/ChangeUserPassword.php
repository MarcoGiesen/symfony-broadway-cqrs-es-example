<?php

namespace App\Domain\User\Command;

use App\Domain\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ChangeUserPassword implements CommandInterface
{
    /**
     * @var array
     *
     * @Assert\Collection(
     *     fields = {
     *         "uuid" = {
     *             @Assert\NotBlank
     *         },
     *         "oldPassword" = {
     *             @Assert\NotBlank
     *         }
     *         "newPassword" = {
     *             @Assert\NotBlank
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

    public function uuid(): string
    {
        return $this->payload['uuid'];
    }

    public function oldPassword(): string
    {
        return $this->payload['oldPassword'];
    }

    public function newPassword(): string
    {
        return $this->payload['newPassword'];
    }
}
