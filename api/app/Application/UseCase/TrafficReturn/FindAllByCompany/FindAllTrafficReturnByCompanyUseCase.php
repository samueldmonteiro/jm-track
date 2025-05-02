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

    /** @return TrafficReturn[] */
    public function execute(FindAllTrafficReturnByCompanyInputDTO $input): array
    {
        $company = $this->companyRepository->findById($input->companyId);

        if (!$company) {
            throw new CompanyNotFoundException();
        }
        return $this->trafficReturnRepository->findAllByCompany($company);
    }
}
