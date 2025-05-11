<?php

namespace App\UseCase\TrafficReturn\Update;

use App\Contract\Repository\CampaignRepositoryInterface;
use App\Contract\Repository\CompanyRepositoryInterface;
use App\Contract\Repository\TrafficReturnRepositoryInterface;
use App\Contract\Repository\TrafficSourceRepositoryInterface;

class UpdateTrafficReturn
{
    public function __construct(
        private TrafficReturnRepositoryInterface $trafficReturnRepository,
        private TrafficSourceRepositoryInterface $trafficSourceRepository,
        private CompanyRepositoryInterface $companyRepository,
    ) {}

    public function execute(UpdateTrafficReturnInput $input): UpdateTrafficReturnOutput
    {
        $trafficReturn = $this->trafficReturnRepository->findById($input->trafficReturnId);
        $trafficSource = $this->trafficSourceRepository->findById($input->trafficSourceId);
        $company = $this->companyRepository->findById($input->companyId);

        $this->trafficReturnRepository->belongsToCompany($company, $trafficReturn);
        
        $trafficReturn->setTrafficSource($trafficSource);
        $trafficReturn->setAmount($input->amount);
        $trafficReturn->setDate($input->date);

        $this->trafficReturnRepository->update($trafficReturn);

        return new UpdateTrafficReturnOutput(
            $trafficReturn
        );
    }
}
