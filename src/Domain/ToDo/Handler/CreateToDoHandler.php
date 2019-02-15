<?php

namespace App\Domain\ToDo\Handler;

use App\Domain\ToDo\Command\CreateToDo;
use App\Domain\ToDo\ToDoId;
use App\Domain\User\UserId;
use App\Infrastructure\Broadway\Repository\UserRepository;
use Ramsey\Uuid\Uuid;

class CreateToDoHandler
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(CreateToDo $command)
    {
        $userId = new UserId($command->userId());
        
        $user = $this->userRepository->get($userId);
        $user->addToDo(
            $command->todoId(),
            $command->title(),
            $command->description()
        );

        $this->userRepository->save($user);
    }
}
