<?php

declare(strict_types=1);

namespace App\Domain\ToDo\Command;

use App\Domain\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class EditToDoInformation implements CommandInterface
{
    /**
     * @var array
     *
     * @Assert\Collection(
     *     fields = {
     *         "uuid" = {
     *             @Assert\NotBlank
     *         },
     *         "userId" = {
     *             @Assert\NotBlank
     *         },
     *         "title" = {
     *             @Assert\NotBlank
     *         },
     *         "description" = {
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

    public function userId(): string
    {
        return $this->payload['userId'];
    }

    public function title(): string
    {
        return $this->payload['title'];
    }

    public function description(): string
    {
        return $this->payload['description'];
    }
}
