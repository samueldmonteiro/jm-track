<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Company;
use App\Domain\Entity\TrafficExpense;

interface TrafficExpenseRepositoryInterface
{
    public function findById(int $id, array $with = []): ?TrafficExpense;

    /** @return TrafficExpense[] */
    public function findByCompany(Company $company, array $with = []): array;
}
