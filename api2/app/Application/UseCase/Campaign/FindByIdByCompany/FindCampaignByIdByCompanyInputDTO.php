<?php

namespace App\Application\UseCase\Campaign\FindByIdByCompany;
    
class FindCampaignByIdByCompanyInputDTO
{
    public function __construct(
        public int $id,
        public int $companyId,
    ) {}
}
