<?php

namespace App\UseCase\TrafficReturn\FindAllForCompany;

class FindAllTrafficReturnsForCompanyInput
{
    public function __construct(
        public string $companyId
    ) {}
}
