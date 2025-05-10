<?php

namespace App\UseCase\Campaign\Update;

class UpdateCampaignInput
{
    public function __construct(
        public int $companyId,
        public int $campaignId,
        public string $name,
    ) {}
}
