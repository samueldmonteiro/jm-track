<?php

namespace App\Domain\Exception;

use Exception;

class CompanyNotFoundException extends Exception
{
    public function __construct(string $message = 'Esta Compania não existe', int $code = 404)
    {
        parent::__construct($message, $code);
    }
}
