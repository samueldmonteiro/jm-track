<?php

namespace App\Application\UseCase\TrafficExpense\FindAllByCompany;

class FindAllTrafficExpensesByCompanyInputDTO
{
    public function __construct(
        public int $companyId
    ) {}
}
