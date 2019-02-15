<?php

declare(strict_types=1);

namespace App\Domain\ToDo\Aggregate;

use App\Domain\ToDo\DomainEvent\ToDoDescriptionWasEdited;
use App\Domain\ToDo\DomainEvent\ToDoWasMarkedAsDone;
use App\Domain\ToDo\ToDoId;
use App\Domain\User\UserId;
use Broadway\EventSourcing\SimpleEventSourcedEntity;

class ToDo extends SimpleEventSourcedEntity
{
    private $toDoId;
    private $creatorId;
    private $title;
    private $description;
    private $doneAt;

    public function __construct(ToDoId $toDoId, UserId $creatorId, string $title, string $description)
    {
        $this->toDoId = $toDoId;
        $this->creatorId = $creatorId;
        $this->title = $title;
        $this->description = $description;
    }

    public function describe(UserId $userId, string $title, string $description): void
    {
        if ($title === $this->title && $description === $this->description) {
            return;
        }

        $this->apply(new ToDoDescriptionWasEdited(
            $userId,
            $this->toDoId,
            $title,
            $description
        ));
    }

    public function markAsDone(): void
    {
        $this->apply(new ToDoWasMarkedAsDone(
            $this->creatorId,
            $this->toDoId,
            new \DateTimeImmutable()
        ));
    }

    public function applyToDoDescriptionWasEdited(ToDoDescriptionWasEdited $event): void
    {
        $this->title = $event->title();
        $this->description = $event->description();
    }

    public function applyToDoWasMarkedAsDone(ToDoWasMarkedAsDone $event): void
    {
        $this->doneAt = $event->time();
    }
}