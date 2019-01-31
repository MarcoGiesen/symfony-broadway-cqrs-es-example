<?php

namespace App\Domain\User\Handler;

use App\Domain\User\Aggregate\User;
use App\Domain\User\Command\RegisterUser;
use App\Infrastructure\Broadway\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterUserHandler
{
    private $userRepository;
    private $encoder;

    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $encoder)
    {
        $this->userRepository = $userRepository;
        $this->encoder = $encoder;
    }

    public function __invoke(RegisterUser $registerUser)
    {
        $user = User::registerUser(
            $registerUser->getUserId(),
            $registerUser->username(),
            $registerUser->email(),
            $registerUser->password()
        );

        $this->userRepository->save($user);
    }
}
