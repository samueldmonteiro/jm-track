<?php

namespace App\UseCase\Campaign\FindByIdForCompany;

class FindCampaignByIdForCompanyInput
{
    public function __construct(
        public string $companyId,
        public string $campaignId
    ) {}
}
