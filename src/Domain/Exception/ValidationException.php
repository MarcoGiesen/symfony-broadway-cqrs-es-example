<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use App\Domain\DomainException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends DomainException
{
    /**
     * @var ConstraintViolationListInterface
     */
    protected $violations = [];

    public function __construct(ConstraintViolationListInterface $violations)
    {
        $errorMessage = sprintf('%s violations found', $violations->count());

        $this->violations = $violations;

        parent::__construct($errorMessage);
    }

    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}
