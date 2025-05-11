<?php

namespace App\UseCase\Campaign\FindAllForCompany;

class FindAllCampaignsForCompanyInput
{
    public function __construct(
        public string $companyId,
    ) {}
}
