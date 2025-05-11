<?php

namespace App\UseCase\Campaign\FindByIdForCompany;

use App\Contract\Repository\CampaignRepositoryInterface;
use App\Contract\Repository\CompanyRepositoryInterface;

class FindCampaignByIdForCompany
{
    public function __construct(
        private CampaignRepositoryInterface $campaignRepository,
        private CompanyRepositoryInterface $companyRepository,
    ) {}

    public function execute(FindCampaignByIdForCompanyInput $input): FindCampaignByIdForCompanyOutput
    {
        $company = $this->companyRepository->findById($input->companyId);
        $campaign = $this->campaignRepository->findByIdForCompany(
            $company,
            $input->campaignId
        );

        return new FindCampaignByIdForCompanyOutput(
            $campaign
        );
    }
}
