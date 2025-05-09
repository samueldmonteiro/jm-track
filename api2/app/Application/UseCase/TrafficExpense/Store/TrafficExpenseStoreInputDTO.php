<?php

namespace App\Application\UseCase\TrafficExpense\Store;

use App\Domain\ValueObject\Amount;
use DateTimeImmutable;

class TrafficExpenseStoreInputDTO
{
    public function __construct(
        public int $companyId,
        public int $trafficSourceId,
        public int $campaignId,
        public DateTimeImmutable $date,
        public Amount $amount
    ) {}
}
