<?php

namespace App\UseCase\Campaign\Update;

use App\Contract\Repository\CampaignRepositoryInterface;
use App\Contract\Repository\CompanyRepositoryInterface;
use App\Exception\CampaignDoesNotBelongToCompanyException;

class UpdateCampaign
{
    public function __construct(
        private CampaignRepositoryInterface $campaignRepository,
        private CompanyRepositoryInterface $companyRepository,
    ) {}

    public function execute(UpdateCampaignInput $input): UpdateCampaignOutput
    {
        $company = $this->companyRepository->findById($input->companyId);
        $campaign = $this->campaignRepository->findById($input->campaignId);
        $this->campaignRepository->campaignBelongsToCompany($company, $campaign);

        $campaign->setName($input->name);
        $this->campaignRepository->update($campaign);

        return new UpdateCampaignOutput($campaign);
    }
}
