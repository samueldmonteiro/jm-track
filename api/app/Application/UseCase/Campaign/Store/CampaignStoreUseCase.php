<?php

namespace App\Application\UseCase\Campaign\Store;

use App\Application\DTO\CampaignDTO;
use App\Domain\Entity\Campaign;
use App\Domain\Enum\CampaignStatus;
use App\Domain\Exception\CompanyNotFoundException;
use App\Domain\Repository\CampaignRepositoryInterface;
use App\Domain\Repository\CompanyRepositoryInterface;

class CampaignStoreUseCase
{
    public function __construct(
        private CampaignRepositoryInterface $campaignRepository,
        private CompanyRepositoryInterface $companyRepository
    ) {}

    public function execute(CampaignStoreInputDTO $dto): CampaignDTO
    {
        $company = $this->companyRepository->findById($dto->companyId);

        if (!$company) {
            throw new CompanyNotFoundException();
        }

        $newCampaign = new Campaign(
            null,
            $company,
            $dto->name,
            CampaignStatus::OPEN,
            $dto->startDate,
        );

        $newCampaign = $this->campaignRepository->store($newCampaign);
        
        return new CampaignDTO(
            $newCampaign->getId(),
            $newCampaign->getName(),
            CampaignStatus::OPEN,
            $newCampaign->getStartDate(),
            $newCampaign->getEndDate(),
            $newCampaign->getCompany(),
        );
    }
}
