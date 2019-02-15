<?php

namespace App\Domain\User\Handler;

use App\Domain\User\Command\ChangeUserPassword;
use App\Domain\User\UserId;
use App\Infrastructure\Broadway\Repository\UserRepository;

class ChangeUserPasswordHandler
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(ChangeUserPassword $command)
    {
        $userId = new UserId($command->getUuid());
        
        $user = $this->userRepository->get($userId);
        $user->changePassword($userId, $command->oldPassword(), $command->newPassword());

        $this->userRepository->save($user);
    }
}
