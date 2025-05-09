<?php

namespace App\Domain\Exception;

use Exception;

class CompanyIncorrectLoginException extends Exception
{
    public function __construct(string $message = 'Login Incorreto', int $code = 401)
    {
        parent::__construct($message, $code);
    }
}