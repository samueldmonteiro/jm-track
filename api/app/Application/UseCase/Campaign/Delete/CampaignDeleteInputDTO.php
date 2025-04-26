<?php

namespace App\Application\UseCase\Campaign\Delete;

class CampaignDeleteInputDTO
{
    public function __construct(
        public int $companyId,
        public int $campaignId
    ) {}
}
