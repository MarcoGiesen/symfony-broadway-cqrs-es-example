<?php

declare(strict_types=1);

namespace App\Domain\ToDo\Command;

use App\Domain\CommandInterface;
use Symfony\Component\Validator\Constraints as Assert;

class MarkToDoAsDone implements CommandInterface
{
    /**
     * @var array
     *
     * @Assert\Collection(
     *     fields = {
     *         "uuid" = {
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
}
