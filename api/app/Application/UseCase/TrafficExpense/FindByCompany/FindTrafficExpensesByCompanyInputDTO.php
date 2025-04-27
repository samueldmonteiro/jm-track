<?php

namespace App\Application\UseCase\TrafficExpense\FindByCompany;

class FindTrafficExpensesByCompanyInputDTO
{
    public function __construct(
        public int $companyId
    ) {}
}
