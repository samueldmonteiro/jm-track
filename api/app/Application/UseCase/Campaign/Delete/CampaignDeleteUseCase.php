<?php

namespace App\Application\UseCase\Campaign\Delete;

use App\Domain\Exception\CampaignNotFoundException;
use App\Domain\Exception\CompanyNotFoundException;
use App\Domain\Exception\DeleteCampaignNotAuthorizedByCompany;
use App\Domain\Repository\CampaignRepositoryInterface;
use App\Domain\Repository\CompanyRepositoryInterface;

class CampaignDeleteUseCase
{
    public function __construct(
        private CampaignRepositoryInterface $campaignRepository,
        private CompanyRepositoryInterface $companyRepository
    ) {}

    public function execute(CampaignDeleteInputDTO $input): bool
    {
        $company = $this->companyRepository->findById($input->companyId);

        if (!$company) {
            throw new CompanyNotFoundException();
        }

        $campaign = $this->campaignRepository->findById($input->campaignId, ['company']);

        if (!$campaign) {
            throw new CampaignNotFoundException();
        }

        if (!$this->companyRepository->campaignBelongsToCompany(
            $input->campaignId,
            $input->companyId
        )) {
            throw new DeleteCampaignNotAuthorizedByCompany();
        }

        return $this->campaignRepository->delete($campaign->getId());
    } 
}
