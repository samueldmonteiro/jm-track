<?php

namespace App\UseCase\TrafficTransaction\FindAllForCompany;

use App\Contract\Repository\CompanyRepositoryInterface;
use App\Contract\Repository\TrafficTransactionRepositoryInterface;

class FindAllTrafficTransactionsForCompany
{
    public function __construct(
        private TrafficTransactionRepositoryInterface $trafficTransactionRepository,
        private CompanyRepositoryInterface $companyRepository
    ) {}

    public function execute(FindAllTrafficTransactionsForCompanyInput $input)
    {
        $company = $this->companyRepository->findById($input->companyId);

        $trafficTransactions = $this->trafficTransactionRepository->findAllForCompany($company);

        return new FindAllTrafficTransactionsForCompanyOutput(
            $trafficTransactions
        );
    }
}
