<?php

namespace App\UseCase\TrafficTransaction\Delete;

use App\Contract\Repository\CompanyRepositoryInterface;
use App\Contract\Repository\TrafficTransactionRepositoryInterface;

class DeleteTrafficTransaction
{
    public function __construct(
        private TrafficTransactionRepositoryInterface $trafficTransactionRepository,
        private CompanyRepositoryInterface $companyRepository,

    ) {}

    public function execute(DeleteTrafficTransactionInput $input): DeleteTrafficTransactionOutput
    {
        $trafficTransaction = $this->trafficTransactionRepository->findById($input->trafficTransactionId);
        $company = $this->companyRepository->findById($input->companyId);
        
        $this->trafficTransactionRepository->belongsToCompany($company, $trafficTransaction);

        return new DeleteTrafficTransactionOutput(
            $this->trafficTransactionRepository->delete($trafficTransaction)
        );
    }
}
