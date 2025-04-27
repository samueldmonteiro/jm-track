<?php

namespace App\Application\UseCase\Campaign\FindCampaignsForCompany;

use App\Application\DTO\CampaignDTO;
use App\Application\DTO\CampaignWithoutRelationsDTO;
use App\Domain\Exception\CompanyNotFoundException;
use App\Domain\Repository\CampaignRepositoryInterface;
use App\Domain\Repository\CompanyRepositoryInterface;

class FindCampaignsForCompanyUseCase
{
    public function __construct(
        private CampaignRepositoryInterface $campaignRepository,
        private CompanyRepositoryInterface $companyRepository
    ) {}

    /**
     * @return CampaignDTO[]
     */
    public function execute(FindCampaignsForCompanyInputDTO $dto): array
    {
        $company = $this->companyRepository->findById($dto->companyId);

        if (!$company) {
            throw new CompanyNotFoundException();
        }

        $campaigns = $this->campaignRepository->findByCompany($company, ['company']);
        
        return array_map(function ($campaign) {
            return new CampaignWithoutRelationsDTO(
                $campaign->getId(),
                $campaign->getName(),
                $campaign->getStatus(),
                $campaign->getStartDate(),
                $campaign->getEndDate(),
            );
        }, $campaigns);
    }
}
