<?php

namespace App\Application\UseCase\Campaign\Update;

use App\Domain\Entity\Campaign;
use App\Domain\Exception\CampaignNotFoundException;
use App\Domain\Repository\CampaignRepositoryInterface;
use App\Domain\Repository\CompanyRepositoryInterface;

class CampaignUpdateUseCase
{
    public function __construct(
        private CampaignRepositoryInterface $campaignRepository,
        private CompanyRepositoryInterface $companyRepository
    ) {}

    public function execute(CampaignUpdateInputDTO $input): Campaign
    {
        $campaign = $this->campaignRepository->findById($input->campaignId);

        if(!$campaign){
            throw new CampaignNotFoundException();
        }

        $campaign->setName($input->name);
        return $this->campaignRepository->update($campaign);
    }
}
