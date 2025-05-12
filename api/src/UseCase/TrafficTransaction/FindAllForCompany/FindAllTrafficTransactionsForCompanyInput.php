<?php

namespace App\UseCase\TrafficTransaction\FindAllForCompany;

class FindAllTrafficTransactionsForCompanyInput
{
    public function __construct(
        public string $companyId
    ) {}
}
