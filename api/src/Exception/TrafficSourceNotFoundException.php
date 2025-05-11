<?php

namespace App\Exception;

class TrafficSourceNotFoundException extends \Exception
{
    public function __construct(
        string $message = 'Esta Tipo de tráfego pago não existe',
        int $code = 404
    ) {
        parent::__construct($message, $code);
    }
}
