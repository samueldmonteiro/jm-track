<?php

namespace App\Application\UseCase\TrafficReturn\FindallWithTotalAmountByCompany;

class FindAllTrafficReturnWithTotalAmountByCompanyInputDTO
{
    public function __construct(
        public int $companyId
    ) {}
}
