<?php

namespace App\Domain\ToDo;

use App\Domain\CommandInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

abstract class CreateToDoCommand implements CommandInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    private $toDoId;

    public function __construct()
    {
        $this->toDoId = new ToDoId(Uuid::uuid4()->toString());
    }

    public function todoId(): ToDoId
    {
        return $this->toDoId;
    }
}