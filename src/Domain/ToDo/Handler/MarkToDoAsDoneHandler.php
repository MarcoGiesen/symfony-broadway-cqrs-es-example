<?php

namespace App\Domain\ToDo\Handler;

use App\Domain\ToDo\Command\EditToDoInformation;
use App\Domain\ToDo\ToDoId;
use App\Domain\User\UserId;
use App\Infrastructure\Broadway\Repository\UserRepository;

class MarkToDoAsDoneHandler
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(EditToDoInformation $command)
    {
        $userId = new UserId($command->userId());
        
        $user = $this->userRepository->get($userId);
        $user->markToDoAsDone(new ToDoId($command->uuid()));

        $this->userRepository->save($user);
    }
}
