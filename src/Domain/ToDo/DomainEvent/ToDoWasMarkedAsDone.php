<?php

namespace App\Domain\ToDo\DomainEvent;

use App\Domain\ToDo\ToDoEvent;
use App\Domain\ToDo\ToDoId;
use App\Domain\User\UserId;

class ToDoWasMarkedAsDone extends ToDoEvent
{
    private $time;
    private $userId;

    public function __construct(UserId $userId, ToDoId $toDoId, \DateTimeImmutable $dateTimeImmutable)
    {
        parent::__construct($toDoId);
        $this->time = $dateTimeImmutable;
        $this->userId = $userId;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function time(): \DateTimeImmutable
    {
        return $this->time;
    }

    public static function deserialize(array $data): self
    {
        return new self(
            new UserId($data['userId']),
            new ToDoId($data['toDoId']),
            new \DateTimeImmutable($data['time'])
        );
    }

    public function serialize(): array
    {
        return array_merge(parent::serialize(), array(
            'userId' => (string)$this->userId,
            'time' => $this->time->format(\DateTimeImmutable::ATOM),
        ));
    }
}
