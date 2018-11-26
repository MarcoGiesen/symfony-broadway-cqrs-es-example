<?php

namespace App\Infrastructure\Controller;

use App\Domain\CommandResolver;
use App\Domain\User\Command\ChangeUserEmail;
use App\Domain\User\Command\RegisterUser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController
{
    private $bus;
    private $resolver;

    public function __construct(MessageBusInterface $bus, CommandResolver $resolver)
    {
        $this->bus = $bus;
        $this->resolver = $resolver;
    }

    /**
     * @Route("/user/register", methods={"POST"}, name="user_register")
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \ReflectionException
     */
    public function registerAction(Request $request): JsonResponse
    {
        /** @var RegisterUser $registerUser */
        $registerUser = $this->resolver->resolve($request, RegisterUser::class);

        $this->bus->dispatch($registerUser);

        return new JsonResponse([
            'status' => 'success',
            'message' => 'ok',
            'id' => (string)$registerUser->getUserId()
        ]);
    }

    /**
     * @Route("/user/changeEmail", methods={"POST"}, name="user_change_email")
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \ReflectionException
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
