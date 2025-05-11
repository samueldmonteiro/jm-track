<?php

namespace App\UseCase\Campaign\FindAllForCompany;

use App\Contract\Repository\CampaignRepositoryInterface;
use App\Contract\Repository\CompanyRepositoryInterface;

class FindAllCampaignsForCompany
{
    public function __construct(
        private CampaignRepositoryInterface $campaignRepository,
        private CompanyRepositoryInterface $companyRepository,
    ) {}

    public function execute(FindAllCampaignsForCompanyInput $input): FindAllCampaignsForCompanyOutput
    {
        $company = $this->companyRepository->findById($input->companyId);
        $campaigns = $this->campaignRepository->findAllForCompany($company);

        return new FindAllCampaignsForCompanyOutput(
            $campaigns
        );
    }
}
