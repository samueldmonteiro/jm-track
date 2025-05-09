<?php

namespace App\Application\UseCase\TrafficReturn\FindAllByCompany;

class FindAllTrafficReturnByCompanyOutputDTO
{
    public function __construct(
        public array $trafficReturns,
        public string $totalAmount
    ) {}
}
