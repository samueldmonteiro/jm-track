<?php

namespace App\Application\UseCase\TrafficReturn\FindallWithTotalAmountByCompany;

class FindAllTrafficReturnWithTotalAmountByCompanyOutputDTO
{
    public function __construct(
        public array $trafficReturns,
        public float $totalAmount
    ) {}
}
