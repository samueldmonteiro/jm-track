<?php

namespace App\Application\UseCase\TrafficReturn\FindAllByCompany;

class FindAllTrafficReturnByCompanyInputDTO
{
    public function __construct(
        public int $companyId
    ) {}
}
