<?php

namespace App\UseCase\TrafficReturn\FindAllForCompany;

class FindAllTrafficReturnsForCompanyOutput
{
    public function __construct(
        public array $trafficReturns
    ) {}

    public function toArray(): array
    {
        return ['trafficReturns' => $this->trafficReturns];
    }
}
