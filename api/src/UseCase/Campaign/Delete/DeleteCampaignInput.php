<?php

namespace App\UseCase\Campaign\Delete;

class DeleteCampaignInput
{
    public function __construct(
        public int $companyId,
        public int $campaignId,
    ) {}
}
