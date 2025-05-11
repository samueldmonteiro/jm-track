<?php

namespace App\UseCase\TrafficReturn\Create;

use App\Contract\Repository\CampaignRepositoryInterface;
use App\Contract\Repository\CompanyRepositoryInterface;
use App\Contract\Repository\TrafficReturnRepositoryInterface;
use App\Contract\Repository\TrafficSourceRepositoryInterface;
use App\Entity\TrafficReturn;

class CreateTrafficReturn
{
    public function __construct(
        private TrafficReturnRepositoryInterface $trafficReturnRepository,
        private TrafficSourceRepositoryInterface $trafficSourceRepository,
        private CompanyRepositoryInterface $companyRepository,
        private CampaignRepositoryInterface $campaignRepositoryInterface
    ) {}

    public function execute(CreateTrafficReturnInput $input): CreateTrafficReturnOutput
    {
        $company = $this->companyRepository->findById($input->companyId);
        $campaign = $this->campaignRepositoryInterface->findById($input->campaignId);
        $trafficSource = $this->trafficSourceRepository->findById($input->trafficSourceId);

        $trafficReturn = new TrafficReturn(
            $company,
            $campaign,
            $trafficSource,
            $input->amount,
            $input->date
        );

        $trafficReturns = $this->trafficReturnRepository->create($trafficReturn);

        return new CreateTrafficReturnOutput(
            $trafficReturns
        );
    }
}
