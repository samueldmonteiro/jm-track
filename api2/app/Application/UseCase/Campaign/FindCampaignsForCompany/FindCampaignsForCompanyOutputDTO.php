<?php

namespace App\Application\UseCase\Campaign\FindCampaignsForCompany;

use App\Domain\Enum\CampaignStatus;
use DateTimeImmutable;

class FindCampaignsForCompanyOutputDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public CampaignStatus $status,
        public DateTimeImmutable $startDate,
        public float $profit,
        public ?DateTimeImmutable $endDate = null,
        public array $trafficExpenses,
        public array $trafficReturns,
        public array $campaignMetrics,
    ) {}
}
