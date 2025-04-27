<?php

namespace App\Application\UseCase\TrafficExpense\FindByCompany;

use App\Application\DTO\TrafficExpenseWithoutRelationsDTO;
use App\Domain\Exception\CompanyNotFoundException;
use App\Domain\Repository\CompanyRepositoryInterface;
use App\Domain\Repository\TrafficExpenseRepositoryInterface;

class FindTrafficExpensesByCompanyUseCase
{
    public function __construct(
        private TrafficExpenseRepositoryInterface $trafficExpenseRepository,
        private CompanyRepositoryInterface $companyRepository
    ) {}

    public function execute(FindTrafficExpensesByCompanyInputDTO $input): array
    {
        $company = $this->companyRepository->findById($input->companyId);

        if (!$company) {
            throw new CompanyNotFoundException();
        }

        return array_map(function ($te) {
            return new TrafficExpenseWithoutRelationsDTO(
                $te->getDate(),
                $te->getAmount()->getValue()
            );
        }, $this->trafficExpenseRepository->findByCompany($company));
    }
}
