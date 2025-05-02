<?php

namespace App\Application\UseCase\TrafficReturn\FindallWithTotalAmountByCompany;

use App\Domain\Exception\CompanyNotFoundException;
use App\Domain\Repository\CompanyRepositoryInterface;
use App\Domain\Repository\TrafficReturnRepositoryInterface;

class FindAllTrafficReturnWithTotalAmountByCompanyUseCase
{
    public function __construct(
        private TrafficReturnRepositoryInterface $trafficReturnRepository,
        private CompanyRepositoryInterface $companyRepository
    ) {}

    public function execute(
        FindAllTrafficReturnWithTotalAmountByCompanyInputDTO $input
    ): FindAllTrafficReturnWithTotalAmountByCompanyOutputDTO {
        $company = $this->companyRepository->findById($input->companyId);

        if (!$company) {
            throw new CompanyNotFoundException();
        }

        $trafficReturns = $this->trafficReturnRepository->findAllByCompany($company);

        $totalAmount = array_reduce(
            $trafficReturns,
            fn($carry, $tr) => $carry + $tr->getAmount()->getValue(),
            0
        );

        $trafficReturnsToArray = array_map(
            fn($tr) => $tr->toArray(),
            $trafficReturns
        );

        return new FindAllTrafficReturnWithTotalAmountByCompanyOutputDTO(
            $trafficReturnsToArray,
            $totalAmount
        );
    }
}
