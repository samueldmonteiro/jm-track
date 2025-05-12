<?php

namespace App\Exception;

class TrafficTransactionDoesNotBelongToCompanyException extends \Exception
{
    public function __construct(
        string $message = 'Esta Transação não pertence à Companhia',
        int $code = 401
    ) {
        parent::__construct($message, $code);
    }
}
