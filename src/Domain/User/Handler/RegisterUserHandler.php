<?php

namespace App\Domain\User\Handler;

use App\Domain\User\Aggregate\User;
use App\Domain\User\Command\RegisterUser;
use App\Infrastructure\Broadway\Repository\UserRepository;

class RegisterUserHandler
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(RegisterUser $registerUser)
    {
        $user = User::registerUser(
            $registerUser->getUserId(),
            $registerUser->getUsername(),
            $registerUser->getEmail()
        );

        $this->userRepository->save($user);
    }
}
