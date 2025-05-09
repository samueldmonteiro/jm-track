<?php

namespace App\Application\UseCase\Campaign\FindCampaignsForCompany;

class FindCampaignsForCompanyInputDTO
{
    public function __construct(
        public int $companyId
    ) {}
}
