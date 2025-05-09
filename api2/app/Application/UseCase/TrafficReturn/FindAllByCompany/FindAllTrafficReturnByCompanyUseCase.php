<?php

namespace App\Application\UseCase\TrafficReturn\FindAllByCompany;

use App\Domain\Exception\CompanyNotFoundException;
use App\Domain\Repository\CompanyRepositoryInterface;
use App\Domain\Repository\TrafficReturnRepositoryInterface;

class FindAllTrafficReturnByCompanyUseCase
{
    public function __construct(
        private TrafficReturnRepositoryInterface $trafficReturnRepository,
        private CompanyRepositoryInterface $companyRepository
    ) {}

    public function execute(
        FindAllTrafficReturnByCompanyInputDTO $input
    ): FindAllTrafficReturnByCompanyOutputDTO {
        $company = $this->companyRepository->findById($input->companyId);

        if (!$company) {
            throw new CompanyNotFoundException();
        }

        $trafficReturns = $this->trafficReturnRepository->findAllByCompany($company, ['trafficSource']);

        $totalAmount = array_reduce(
            $trafficReturns,
            fn($carry, $tr) => $carry + $tr->getAmount()->getValue(),
            0
        );

        $trafficReturnsToArray = array_map(
            fn($tr) => $tr->toArray(),
            $trafficReturns
        );

        return new FindAllTrafficReturnByCompanyOutputDTO(
            $trafficReturnsToArray,
            $totalAmount
        );
    }
}
