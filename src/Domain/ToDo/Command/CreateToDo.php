<?php

declare(strict_types=1);

namespace App\Domain\ToDo\Command;

use App\Domain\ToDo\CreateToDoCommand;
use Symfony\Component\Validator\Constraints as Assert;

class CreateToDo extends CreateToDoCommand
{
    /**
     * @var array
     *
     * @Assert\Collection(
     *     fields = {
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
        parent::__construct();

        $this->payload = $payload;
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
