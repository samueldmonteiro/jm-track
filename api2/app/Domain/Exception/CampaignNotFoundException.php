<?php

namespace App\Domain\Exception;

use Exception;

class CampaignNotFoundException extends Exception
{
    public function __construct(string $message = 'Campanha não encontrada', int $code = 404)
    {
        parent::__construct($message, $code);
    }
}
