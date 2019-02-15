<?php

namespace App\Domain\ToDo;

use Broadway\Serializer\Serializable;

abstract class ToDoEvent implements Serializable
{
    private $toDoId;

    public function __construct(ToDoId $toDoId)
    {
        $this->toDoId = $toDoId;
    }

    public function toDoId(): ToDoId
    {
        return $this->toDoId;
    }

    public function serialize(): array
    {
        return ['toDoId' => (string)$this->toDoId];
    }
}
