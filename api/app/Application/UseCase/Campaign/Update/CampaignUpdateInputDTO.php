<?php

namespace App\Application\UseCase\Campaign\Update;

class CampaignUpdateInputDTO
{
    public function __construct(
        public int $companyId,
        public int $campaignId,
        public string $name
    ) {}
}
