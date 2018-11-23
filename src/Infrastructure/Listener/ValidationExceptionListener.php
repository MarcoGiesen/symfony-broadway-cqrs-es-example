<?php

namespace App\Infrastructure\Listener;

use App\Domain\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $response = $this->transformException($event->getException());

        if ($response !== null) {
            $event->setResponse($response);
        }
    }

    private function transformException(\Exception $exception): ?JsonResponse
    {
        if ($exception instanceof ValidationException) {
            return new JsonResponse(
                [
                    'code' => 400,
                    'message' => 'Validation errors.',
                    'data' => $this->transformViolationList($exception->getViolations()),
                ],
                400
            );
        }

        return null;
    }

    private function transformViolationList(ConstraintViolationListInterface $violationList): array
    {
        $errors = [];

        /** @var ConstraintViolation $violation */
        foreach ($violationList as $violation) {
            $errors[] = [
                'property' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
            ];
        }

        return $errors;
    }
}
