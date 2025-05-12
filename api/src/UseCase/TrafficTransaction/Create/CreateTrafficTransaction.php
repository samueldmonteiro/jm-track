<?php

namespace App\UseCase\TrafficTransaction\Create;

use App\Contract\Repository\CampaignRepositoryInterface;
use App\Contract\Repository\CompanyRepositoryInterface;
use App\Contract\Repository\TrafficTransactionRepositoryInterface;
use App\Contract\Repository\TrafficSourceRepositoryInterface;
use App\Entity\TrafficTransaction;

class CreateTrafficTransaction
{
    public function __construct(
        private TrafficTransactionRepositoryInterface $trafficTransactionRepository,
        private TrafficSourceRepositoryInterface $trafficSourceRepository,
        private CompanyRepositoryInterface $companyRepository,
        private CampaignRepositoryInterface $campaignRepositoryInterface
    ) {}

    public function execute(CreateTrafficTransactionInput $input): CreateTrafficTransactionOutput
    {
        $company = $this->companyRepository->findById($input->companyId);
        $campaign = $this->campaignRepositoryInterface->findById($input->campaignId);
        $trafficSource = $this->trafficSourceRepository->findById($input->trafficSourceId);

        $trafficTransaction = new TrafficTransaction(
            $company,
            $campaign,
            $trafficSource,
            $input->amount,
            $input->date,
            $input->type
        );

        $trafficTransactions = $this->trafficTransactionRepository->create($trafficTransaction);

        return new CreateTrafficTransactionOutput(
            $trafficTransactions
        );
    }
}
