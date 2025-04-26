<?php

namespace App\Application\UseCase\Campaign\Update;

use App\Application\DTO\CampaignDTO;
use App\Domain\Exception\CampaignNotFoundException;
use App\Domain\Repository\CampaignRepositoryInterface;
use App\Domain\Repository\CompanyRepositoryInterface;

class CampaignUpdateUseCase
{
    public function __construct(
        private CampaignRepositoryInterface $campaignRepository,
        private CompanyRepositoryInterface $companyRepository
    ) {}

    public function execute(CampaignUpdateInputDTO $input): CampaignDTO
    {
        $campaign = $this->campaignRepository->findById($input->campaignId);

        if(!$campaign){
            throw new CampaignNotFoundException();
        }

        $campaign->setName($input->name);
        $updateCampaign = $this->campaignRepository->update($campaign);

        return new CampaignDTO(
            $updateCampaign->getId(),
            $updateCampaign->getName(),
            $updateCampaign->getStatus(),
            $updateCampaign->getStartDate(),
            $updateCampaign->getEndDate(),
        );
    }
}
