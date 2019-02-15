<?php

namespace App\Domain\ToDo\DomainEvent;

use App\Domain\ToDo\ToDoEvent;
use App\Domain\ToDo\ToDoId;
use App\Domain\User\UserId;

class ToDoWasCreated extends ToDoEvent
{
    private $title;
    private $description;
    private $userId;

    public function __construct(UserId $userId, ToDoId $toDoId, string $title, string $description)
    {
        parent::__construct($toDoId);
        $this->title = $title;
        $this->userId = $userId;
        $this->description = $description;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public static function deserialize(array $data): self
    {
        return new self(
            new UserId($data['userId']),
            new ToDoId($data['toDoId']),
            $data['title'],
            $data['description']
        );
    }

    public function serialize(): array
    {
        return array_merge(parent::serialize(), array(
            'userId'   => (string)$this->userId,
            'title'   => $this->title,
            'description' => $this->description,
        ));
    }
}
