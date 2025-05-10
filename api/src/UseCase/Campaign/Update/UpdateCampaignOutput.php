<?php

namespace App\UseCase\Campaign\Update;

use App\Entity\Campaign;

class UpdateCampaignOutput
{
    public function __construct(
        public Campaign $campaign
    ) {}
}
