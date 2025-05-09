<?php

namespace App\Application\UseCase\TrafficExpense\Store;

use App\Domain\Entity\TrafficExpense;
use App\Domain\Exception\CampaignNotFoundException;
use App\Domain\Exception\CompanyNotFoundException;
use App\Domain\Exception\TrafficSourceNotFoundException;
use App\Domain\Repository\CampaignRepositoryInterface;
use App\Domain\Repository\CompanyRepositoryInterface;
use App\Domain\Repository\TrafficExpenseRepositoryInterface;
use App\Domain\Repository\TrafficSourceRepositoryInterface;

class TrafficExpenseStoreUseCase
{
    public function __construct(
        private TrafficExpenseRepositoryInterface $trafficExpenseRepository,
        private CompanyRepositoryInterface $companyRepository,
        private CampaignRepositoryInterface $campaignRepository,
        private TrafficSourceRepositoryInterface $trafficSourceRepository
    ) {}

    public function execute(TrafficExpenseStoreInputDTO $input): TrafficExpense
    {
        $company = $this->companyRepository->findById($input->companyId);

        if (!$company) {
            throw new CompanyNotFoundException();
        }

        $campaign = $this->campaignRepository->findById($input->campaignId);

        if (!$campaign) {
            throw new CampaignNotFoundException();
        }

        $trafficSource = $this->trafficSourceRepository->findById($input->trafficSourceId);

        if (!$trafficSource) {
            throw new TrafficSourceNotFoundException();
        }

        $trafficExpense = new TrafficExpense(
            null,
            $company,
            $trafficSource,
            $campaign,
            $input->date,
            $input->amount
        );

        return $this->trafficExpenseRepository->store($trafficExpense);
    }
}
