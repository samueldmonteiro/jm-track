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
    public function execute(FindAllTrafficExpensesByCompanyInputDTO $input): FindAllTrafficExpensesByCompanyOutputDTO
    {
        $company = $this->companyRepository->findById($input->companyId);

        if (!$company) {
            throw new CompanyNotFoundException();
        }

        $trafficExpenses =  $this->trafficExpenseRepository->findAllByCompany($company, ['trafficSource']);

        $totalAmount = array_reduce(
            $trafficExpenses,
            fn($carry, $tr) => $carry + $tr->getAmount()->getValue(),
            0
        );

        $trafficExpensesToArray = array_map(
            fn($te) => $te->toArray(),
            $trafficExpenses
        );

        return new FindAllTrafficExpensesByCompanyOutputDTO(
            $trafficExpensesToArray,
            $totalAmount
        );
    }
}
