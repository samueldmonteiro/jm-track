<?php

namespace App\UseCase\TrafficTransaction\FindAllForCompany;

class FindAllTrafficTransactionsForCompanyOutput
{
    public function __construct(
        public array $trafficTransactions
    ) {}

    public function toArray(): array
    {
        return ['trafficTransactions' => $this->trafficTransactions];
    }
}
