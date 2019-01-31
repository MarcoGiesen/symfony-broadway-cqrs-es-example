<?php

declare(strict_types=1);

namespace App\Infrastructure\Broadway\Projection;

use App\Domain\User\DomainEvent\UserEmailWasChanged;
use App\Domain\User\DomainEvent\UserPasswordWasChanged;
use App\Domain\User\DomainEvent\UserWasRegistered;
use App\Infrastructure\MongoDb\MongoDbManager;
use Broadway\ReadModel\Projector;

class UserProjection extends Projector
{
    private $mongoDbManager;

    public function __construct(MongoDbManager $mongoDbManager)
    {
        $this->mongoDbManager = $mongoDbManager;
    }

    public function applyUserWasRegistered(UserWasRegistered $event): void
    {
        $this->mongoDbManager->collection('user')->insertOne([
            '_id' => (string)$event->userId(),
            'email' => $event->email(),
            'username' => $event->username(),
            'password' => $event->password(),
        ]);
    }

    public function applyUserEmailWasChanged(UserEmailWasChanged $event): void
    {
        $this->mongoDbManager->collection('user')->updateOne(
            [
                '_id' => (string)$event->userId()
            ],
            [
                '$set' => ['email' => $event->email()],
            ]
        );
    }

    public function applyUserPasswordWasChanged(UserPasswordWasChanged $event): void
    {
        $this->mongoDbManager->collection('user')->updateOne(
            [
                '_id' => (string)$event->userId()
            ],
            [
                '$set' => ['password' => $event->password()],
            ]
        );
    }
}
