<?php

namespace App\Application\UseCase\TrafficExpense\FindAllByCompany;

class FindAllTrafficExpensesByCompanyOutputDTO
{
    public function __construct(
        public array $trafficExpenses,
        public string $totalAmount
    ) {}
}
