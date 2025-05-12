<?php

namespace App\Exception;

class TrafficTransactionNotFoundException extends \Exception
{
    public function __construct(
        string $message = 'Transação de Tráfego não encontrado',
        int $code = 404
    ) {
        parent::__construct($message, $code);
    }
}
