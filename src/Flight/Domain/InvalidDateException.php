<?php

namespace App\Flight\Domain;

use Exception;
use Throwable;

class InvalidDateException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}