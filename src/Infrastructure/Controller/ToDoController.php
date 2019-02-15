<?php

namespace App\Infrastructure\Controller;

use App\Domain\CommandResolver;
use App\Domain\ToDo\Command\CreateToDo;
use App\Domain\ToDo\Command\EditToDoInformation;
use App\Domain\ToDo\Command\MarkToDoAsDone;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class ToDoController
{
    private $bus;
    private $resolver;

    public function __construct(MessageBusInterface $bus, CommandResolver $resolver)
    {
        $this->bus = $bus;
        $this->resolver = $resolver;
    }

    /**
     * @Route("/todo/add", methods={"POST"}, name="todo_add")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function addToDoAction(Request $request): JsonResponse
    {
        /** @var CreateToDo $command */
        $command = $this->resolver->resolve($request, CreateToDo::class);

        $this->bus->dispatch($command);

        return new JsonResponse([
            'status' => 'success',
            'id' => (string)$command->todoId()
        ]);
    }

    /**
     * @Route("/todo/change", methods={"POST"}, name="todo_change")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function changeToDoAction(Request $request): JsonResponse
    {
        $command = $this->resolver->resolve($request, EditToDoInformation::class);

        $this->bus->dispatch($command);

        return new JsonResponse([
            'status' => 'success',
            'message' => 'ok'
        ]);
    }

    /**
     * @Route("/todo/done", methods={"POST"}, name="todo_done")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function markToDoAsDoneAction(Request $request): JsonResponse
    {
        $command = $this->resolver->resolve($request, MarkToDoAsDone::class);

        $this->bus->dispatch($command);

        return new JsonResponse([
            'status' => 'success',
            'message' => 'ok'
        ]);
    }
}
