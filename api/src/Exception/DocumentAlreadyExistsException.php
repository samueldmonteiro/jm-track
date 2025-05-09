<?php

namespace App\Domain\Exception;

use Exception;

class DocumentAlreadyExistsException extends Exception
{
    public function __construct(string $message = 'Este documento já está cadastrado', int $code = 401)
    {
        parent::__construct($message, $code);
    }
}