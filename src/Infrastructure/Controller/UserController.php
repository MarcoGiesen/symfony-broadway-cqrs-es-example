<?php

namespace App\Infrastructure\Controller;

use App\Domain\CommandResolver;
use App\Domain\User\Command\ChangeUserEmail;
use App\Domain\User\Command\RegisterUser;
use App\Domain\User\UserId;
use App\Infrastructure\Broadway\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController
{
    private $bus;
    private $resolver;
    private $userRepository;

    public function __construct(MessageBusInterface $bus, CommandResolver $resolver, UserRepository $userRepository)
    {
        $this->bus = $bus;
        $this->resolver = $resolver;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/user/{id}", methods={"GET"}, name="user")
     *
     * @param string $id
     * @return JsonResponse
     * @throws \App\Domain\User\Exception\UserNotFoundException
     */
    public function getAction(string $id): JsonResponse
    {
        $userId = new UserId($id);

        $user = $this->userRepository->get($userId);

        return new JsonResponse([
            'status' => 'success',
            'data' => $user->toArray()
        ]);
    }

    /**
     * @Route("/user/register", methods={"POST"}, name="user_register")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function registerAction(Request $request): JsonResponse
    {
        /** @var RegisterUser $registerUser */
        $registerUser = $this->resolver->resolve($request, RegisterUser::class);

        $this->bus->dispatch($registerUser);

        return new JsonResponse([
            'status' => 'success',
            'id' => (string)$registerUser->getUserId()
        ]);
    }

    /**
     * @Route("/user/changeEmail", methods={"POST"}, name="user_change_email")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function changeEmailAction(Request $request): JsonResponse
    {
        $changeEmail = $this->resolver->resolve($request, ChangeUserEmail::class);

        $this->bus->dispatch($changeEmail);

        return new JsonResponse([
            'status' => 'success',
            'message' => 'ok'
        ]);
    }
}
