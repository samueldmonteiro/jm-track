<?php

namespace App\UseCase\Campaign\Delete;

use App\Contract\Repository\CampaignRepositoryInterface;
use App\Contract\Repository\CompanyRepositoryInterface;
use App\Contract\Repository\TrafficTransactionRepositoryInterface;

class DeleteCampaign
{
    public function __construct(
        private CampaignRepositoryInterface $campaignRepository,
        private CompanyRepositoryInterface $companyRepository,
        private TrafficTransactionRepositoryInterface $trafficTransactionRepository
    ) {}

    public function execute(DeleteCampaignInput $input): DeleteCampaignOutput
    {
        $company = $this->companyRepository->findById($input->companyId);
        $campaign = $this->campaignRepository->findById($input->campaignId);

        array_map(function ($tt) {
            $this->trafficTransactionRepository->delete($tt);
        }, $campaign->getTrafficTransactions()->toArray());

        $this->campaignRepository->campaignBelongsToCompany($company, $campaign);

        return new DeleteCampaignOutput(
            $this->campaignRepository->delete($campaign)
        );
    }
}
