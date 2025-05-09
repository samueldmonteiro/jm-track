<?php

namespace App\Application\UseCase\Campaign\FindByIdByCompany;

use App\Domain\Entity\Campaign;
use App\Domain\Exception\CompanyNotFoundException;
use App\Domain\Repository\CampaignRepositoryInterface;
use App\Domain\Repository\CompanyRepositoryInterface;

class FindCampaignByIdByCompanyUseCase
{
    public function __construct(
        private CampaignRepositoryInterface $campaignRepository,
        private CompanyRepositoryInterface $companyRepository
    ) {}

    /**
     * @return Campaign
     */
    public function execute(FindCampaignByIdByCompanyInputDTO $dto): Campaign
    {
        $company = $this->companyRepository->findById($dto->companyId);

        if (!$company) {
            throw new CompanyNotFoundException();
        }

        $campaign = $this->campaignRepository->findByIdAndByCompany($company, $dto->id, ['trafficReturns', 'trafficExpenses', 'campaignMetrics']);

        return $campaign;
    }
}
