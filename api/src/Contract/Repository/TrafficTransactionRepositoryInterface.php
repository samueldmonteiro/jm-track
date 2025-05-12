<?php

namespace App\Contract\Repository;

use App\Entity\Company;
use App\Entity\TrafficTransaction;
use App\Exception\TrafficTransactionDoesNotBelongToCompanyException;

interface TrafficTransactionRepositoryInterface
{
    public function findAllForCompany(Company $company): array;
    public function findById(int $id, bool $throw = true): ?TrafficTransaction;
    
    public function create(TrafficTransaction $trafficTransaction, bool $throw = true): ?TrafficTransaction;
    public function update(TrafficTransaction $trafficTransaction, bool $throw = true): ?TrafficTransaction;
    public function delete(TrafficTransaction $trafficTransaction, bool $throw = true): bool;

    /**
     *  @throws TrafficTransactionDoesNotBelongToCompanyException
     */
    public function belongsToCompany(
        Company $company,
        TrafficTransaction $trafficTransaction,
        bool $throw = true
    ): bool;
}
