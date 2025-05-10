<?php

namespace App\Exception;

use Exception;

class CampaignDoesNotBelongToCompanyException extends Exception
{
    public function __construct(string $message = 'Esta Campanha não pertence à Companhia', int $code = 401)
    {
        parent::__construct($message, $code);
    }
}
