<?php

namespace App\Application\UseCase\Campaign\FindCampaignsForCompany;

use App\Domain\Exception\CompanyNotFoundException;
use App\Domain\Repository\CampaignRepositoryInterface;
use App\Domain\Repository\CompanyRepositoryInterface;

class FindCampaignsForCompanyUseCase
{
    public function __construct(
        private CampaignRepositoryInterface $campaignRepository,
        private CompanyRepositoryInterface $companyRepository
    ) {}

    /**
     * @return Campaign[]
     */
    public function execute(FindCampaignsForCompanyInputDTO $dto): array
    {
        $company = $this->companyRepository->findById($dto->companyId);

        if (!$company) {
            throw new CompanyNotFoundException();
        }

        $campaigns = $this->campaignRepository->findByCompany($company, ['trafficExpenses', 'trafficReturns', 'campaignMetrics']);

        return array_map(function ($c) {

            $totalExpenses = array_reduce(
                $c->getTrafficExpenses(),
                fn($carry, $tr) => $carry + $tr->getAmount()->getValue(),
                0
            );

            $totalReturns = array_reduce(
                $c->getTrafficReturns(),
                fn($carry, $tr) => $carry + $tr->getAmount()->getValue(),
                0
            );

            $profit = $totalReturns - $totalExpenses;

            $trafficExpenses = array_map(function($te){
                return $te->toArray();
            }, $c->getTrafficExpenses());

            $trafficReturns = array_map(function($te){
                return $te->toArray();
            }, $c->getTrafficReturns());

            $campaignMetrics = array_map(function($te){
                return $te->toArray();
            }, $c->getCampaignMetrics());

            return new FindCampaignsForCompanyOutputDTO(
                $c->getId(),
                $c->getName(),
                $c->getStatus(),
                $c->getStartDate(),
                $profit,
                $c->getEndDate(),
                $trafficExpenses,
                $trafficReturns,
                $campaignMetrics
            );
        }, $campaigns);
    }
}
