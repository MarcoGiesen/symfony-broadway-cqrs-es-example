<?php

namespace App\Domain\ToDo;

use Assert\Assertion as Assert;

class ToDoId
{
    private $toDoId;

    public function __construct(string $toDoId)
    {
        Assert::string($toDoId);
        Assert::uuid($toDoId);

        $this->toDoId = $toDoId;
    }

    public function __toString(): string
    {
        return $this->toDoId;
    }
}
