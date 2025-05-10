<?php

namespace App\UseCase\Campaign\Create;

use App\Entity\Campaign;

class CreateCampaignOutput
{
    public function __construct(
        public Campaign $campaign
    ) {}
}
