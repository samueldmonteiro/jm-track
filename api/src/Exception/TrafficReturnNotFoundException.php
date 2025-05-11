<?php

namespace App\Exception;

class TrafficReturnNotFoundException extends \Exception
{
    public function __construct(
        string $message = 'Retorno de Tráfego não encontrado',
        int $code = 404
    ) {
        parent::__construct($message, $code);
    }
}
