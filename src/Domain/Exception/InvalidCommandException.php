<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use App\Domain\CommandInterface;
use App\Domain\DomainException;
use App\Domain\HandlerInterface;

class InvalidCommandException extends DomainException
{
}
