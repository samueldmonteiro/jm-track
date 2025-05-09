<?php

namespace App\Domain\Exception;

use Exception;

class TrafficSourceNotFoundException extends Exception
{
    public function __construct(string $message = 'Tipo de Tráfego não encontrada', int $code = 404)
    {
        parent::__construct($message, $code);
    }
}
