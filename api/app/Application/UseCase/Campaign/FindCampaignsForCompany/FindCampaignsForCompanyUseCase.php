<?php

namespace App\Application\UseCase\Campaign\FindCampaignsForCompany;

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
     * @return Campaign[]
     */
    public function execute(FindCampaignsForCompanyInputDTO $dto): array
    {
        $company = $this->companyRepository->findById($dto->companyId);

        if (!$company) {
            throw new CompanyNotFoundException();
        }

        return $this->campaignRepository->findByCompany($company);
    }
}
