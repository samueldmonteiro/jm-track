<?php

namespace App\Exception;

class EmailAlreadyExistsException extends \Exception
{
    public function __construct(
        string $message = 'Este e-mail já está cadastrado',
        int $code = 401
    ) {
        parent::__construct($message, $code);
    }
}
