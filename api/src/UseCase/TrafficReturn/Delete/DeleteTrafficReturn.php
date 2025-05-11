<?php

namespace App\UseCase\TrafficReturn\Delete;

use App\Contract\Repository\CompanyRepositoryInterface;
use App\Contract\Repository\TrafficReturnRepositoryInterface;

class DeleteTrafficReturn
{
    public function __construct(
        private TrafficReturnRepositoryInterface $trafficReturnRepository,
        private CompanyRepositoryInterface $companyRepository,

    ) {}

    public function execute(DeleteTrafficReturnInput $input): DeleteTrafficReturnOutput
    {
        $trafficReturn = $this->trafficReturnRepository->findById($input->trafficReturnId);
        $company = $this->companyRepository->findById($input->companyId);
        
        $this->trafficReturnRepository->belongsToCompany($company, $trafficReturn);

        return new DeleteTrafficReturnOutput(
            $this->trafficReturnRepository->delete($trafficReturn)
        );
    }
}
