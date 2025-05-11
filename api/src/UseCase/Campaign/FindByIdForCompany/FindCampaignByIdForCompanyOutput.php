<?php

namespace App\UseCase\Campaign\FindByIdForCompany;

use App\Entity\Campaign;

class FindCampaignByIdForCompanyOutput
{
    public function __construct(
        public Campaign $campaign
    ) {}

    public function toArray(): array
    {
        return ['campaign' => $this->campaign];
    }
}
