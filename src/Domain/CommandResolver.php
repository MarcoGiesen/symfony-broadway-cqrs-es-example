<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Exception\InvalidCommandException;
use App\Domain\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CommandResolver
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function resolve(Request $request, string $commandClass): CommandInterface
    {
        $payload = $request->request->all();
        $parents = \class_implements($commandClass);

        if (!\array_key_exists(CommandInterface::class, $parents)) {
            throw new InvalidCommandException(
                sprintf('"%s" needs to implement "%s"', $commandClass, CommandInterface::class)
            );
        }

        $command = new $commandClass($payload);
        $violations = $this->validator->validate($command);

        if (\count($violations) === 0) {
            return $command;
        }

        throw new ValidationException($violations);
    }
}
