<?php

namespace App\UseCase\Campaign\Create;

use App\Contract\Repository\CampaignRepositoryInterface;
use App\Contract\Repository\CompanyRepositoryInterface;
use App\Entity\Campaign;
use App\Entity\Enum\CampaignStatus;
use DateTimeImmutable;

class CreateCampaign
{
    public function __construct(
        private CampaignRepositoryInterface $campaignRepository,
        private CompanyRepositoryInterface $companyRepository,
    ) {}

    public function execute(CreateCampaignInput $input)
    {
        $company = $this->companyRepository->findById($input->companyId);

        $newCampaign = new Campaign(
            $input->name,
            $company,
            CampaignStatus::OPEN,
            new DateTimeImmutable('now')
        );

        $this->campaignRepository->create($newCampaign);

        return new CreateCampaignOutput($newCampaign);
    }
}
