<?php

namespace App\UseCase\TrafficReturn\FindAllForCompany;

use App\Contract\Repository\CompanyRepositoryInterface;
use App\Contract\Repository\TrafficReturnRepositoryInterface;

class FindAllTrafficReturnsForCompany
{
    public function __construct(
        private TrafficReturnRepositoryInterface $trafficReturnRepository,
        private CompanyRepositoryInterface $companyRepository
    ) {}

    public function execute(FindAllTrafficReturnsForCompanyInput $input)
    {
        $company = $this->companyRepository->findById($input->companyId);

        $trafficReturns = $this->trafficReturnRepository->findAllForCompany($company);

        return new FindAllTrafficReturnsForCompanyOutput(
            $trafficReturns
        );
    }
}
