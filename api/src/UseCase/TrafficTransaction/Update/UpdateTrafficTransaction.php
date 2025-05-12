<?php

namespace App\UseCase\TrafficTransaction\Update;

use App\Contract\Repository\CompanyRepositoryInterface;
use App\Contract\Repository\TrafficTransactionRepositoryInterface;
use App\Contract\Repository\TrafficSourceRepositoryInterface;

class UpdateTrafficTransaction
{
    public function __construct(
        private TrafficTransactionRepositoryInterface $trafficTransactionRepository,
        private TrafficSourceRepositoryInterface $trafficSourceRepository,
        private CompanyRepositoryInterface $companyRepository,
    ) {}

    public function execute(UpdateTrafficTransactionInput $input): UpdateTrafficTransactionOutput
    {
        $trafficTransaction = $this->trafficTransactionRepository->findById($input->trafficTransactionId);
        $trafficSource = $this->trafficSourceRepository->findById($input->trafficSourceId);
        $company = $this->companyRepository->findById($input->companyId);

        $this->trafficTransactionRepository->belongsToCompany($company, $trafficTransaction);
        
        $trafficTransaction->setTrafficSource($trafficSource);
        $trafficTransaction->setAmount($input->amount);
        $trafficTransaction->setDate($input->date);

        $this->trafficTransactionRepository->update($trafficTransaction);

        return new UpdateTrafficTransactionOutput(
            $trafficTransaction
        );
    }
}
