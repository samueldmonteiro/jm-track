<?php

namespace App\UseCase\Campaign\Delete;

use App\Contract\Repository\CampaignRepositoryInterface;
use App\Contract\Repository\CompanyRepositoryInterface;

class DeleteCampaign
{
    public function __construct(
        private CampaignRepositoryInterface $campaignRepository,
        private CompanyRepositoryInterface $companyRepository,
    ) {}

    public function execute(DeleteCampaignInput $input): DeleteCampaignOutput
    {
        $company = $this->companyRepository->findById($input->companyId);
        $campaign = $this->campaignRepository->findById($input->campaignId);

        $this->campaignRepository->campaignBelongsToCompany($company, $campaign);

        return new DeleteCampaignOutput(
            $this->campaignRepository->delete($campaign)
        );
    }
}
