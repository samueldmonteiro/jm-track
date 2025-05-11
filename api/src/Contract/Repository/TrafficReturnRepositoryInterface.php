<?php

namespace App\Contract\Repository;

use App\Entity\Company;
use App\Entity\TrafficReturn;
use App\Exception\TrafficReturnDoesNotBelongToCompanyException;

interface TrafficReturnRepositoryInterface
{

    public function findAllForCompany(Company $company): array;
    public function findById(int $id, bool $throw = true): ?TrafficReturn;
    public function create(TrafficReturn $trafficReturn, bool $throw = true): ?TrafficReturn;
    public function update(TrafficReturn $trafficReturn, bool $throw = true): ?TrafficReturn;
    public function delete(TrafficReturn $trafficReturn, bool $throw = true): bool;

    /**
     *  @throws TrafficReturnDoesNotBelongToCompanyException
     */
    public function belongsToCompany(
        Company $company,
        TrafficReturn $trafficReturn,
        bool $throw = true
    ): bool;
}
