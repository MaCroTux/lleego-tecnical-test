<?php

namespace App\Flight\Domain;

use Exception;
use Throwable;

class XmlReadException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}