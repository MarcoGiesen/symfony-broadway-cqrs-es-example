<?php

declare(strict_types=1);

namespace App\Infrastructure\Broadway\Projection;

use App\Domain\ToDo\DomainEvent\ToDoDescriptionWasEdited;
use App\Domain\ToDo\DomainEvent\ToDoWasCreated;
use App\Domain\ToDo\DomainEvent\ToDoWasMarkedAsDone;
use App\Infrastructure\MongoDb\MongoDbManager;
use Broadway\ReadModel\Projector;

class ToDoProjection extends Projector
{
    private $mongoDbManager;

    public function __construct(MongoDbManager $mongoDbManager)
    {
        $this->mongoDbManager = $mongoDbManager;
    }

    public function applyToDoWasCreated(ToDoWasCreated $event): void
    {
        $this->mongoDbManager->collection('todo')->insertOne([
            '_id' => (string)$event->toDoId(),
            'description' => $event->description(),
            'title' => $event->title(),
            'creatorId' => (string)$event->userId(),
            'doneAt' => null,
        ]);
    }

    public function applyToDoDescriptionWasEdited(ToDoDescriptionWasEdited $event): void
    {
        $this->mongoDbManager->collection('todo')->updateOne(
            [
                '_id' => (string)$event->toDoId()
            ],
            [
                '$set' => ['description' => $event->description(), 'title' => $event->title()],
            ]
        );
    }

    public function applyToDoWasMarkedAsDone(ToDoWasMarkedAsDone $event): void
    {
        $this->mongoDbManager->collection('todo')->updateOne(
            [
                '_id' => (string)$event->toDoId()
            ],
            [
                '$set' => ['doneAt' => $event->time()->format(\DateTimeImmutable::ATOM)],
            ]
        );
    }
}
