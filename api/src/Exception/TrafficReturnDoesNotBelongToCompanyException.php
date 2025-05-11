<?php

namespace App\Exception;

class TrafficReturnDoesNotBelongToCompanyException extends \Exception
{
    public function __construct(
        string $message = 'Esta Retorno de Tráfego não pertence à Companhia',
        int $code = 401
    ) {
        parent::__construct($message, $code);
    }
}
