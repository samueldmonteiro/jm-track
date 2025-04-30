<?php

namespace App\Application\UseCase\TrafficExpense\FindAllByCompany;

use App\Domain\Exception\CompanyNotFoundException;
use App\Domain\Repository\CompanyRepositoryInterface;
use App\Domain\Repository\TrafficExpenseRepositoryInterface;

class FindAllTrafficExpensesByCompanyUseCase
{
    public function __construct(
        private TrafficExpenseRepositoryInterface $trafficExpenseRepository,
        private CompanyRepositoryInterface $companyRepository
    ) {}

    /** @return TrafficExpense[] */
    public function execute(FindAllTrafficExpensesByCompanyInputDTO $input): array
    {
        $company = $this->companyRepository->findById($input->companyId);

        if (!$company) {
            throw new CompanyNotFoundException();
        }
        return $this->trafficExpenseRepository->findAllByCompany($company);
    }
}
