<?php

namespace App\Domain\Exception;

use Exception;

class DeleteCampaignNotAuthorizedByCompany extends Exception
{
    public function __construct(string $message = 'Esta campanha não pertence à esta companhia', int $code = 500)
    {
        parent::__construct($message, $code);
    }
}
