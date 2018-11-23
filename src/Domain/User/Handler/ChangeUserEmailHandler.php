<?php

namespace App\Domain\User\Handler;

use App\Domain\User\Aggregate\User;
use App\Domain\User\Command\ChangeUserEmail;
use App\Domain\User\Command\RegisterUser;
use App\Domain\User\UserId;
use App\Infrastructure\Broadway\Repository\UserRepository;

class ChangeUserEmailHandler
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(ChangeUserEmail $changeUserEmail)
    {
        $userId = new UserId($changeUserEmail->getUuid());
        
        $user = $this->userRepository->get($userId);
        $user->changeEmail($userId, $changeUserEmail->getEmail());

        $this->userRepository->save($user);
    }
}
