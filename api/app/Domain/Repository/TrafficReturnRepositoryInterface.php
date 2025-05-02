<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Company;
use App\Domain\Entity\TrafficReturn;

interface TrafficReturnRepositoryInterface
{
    public function findById(int $id, array $with = []): ?TrafficReturn;

    /** @return TrafficReturn[] */
    public function findAllByCompany(Company $company, array $with = []): array;

    public function store(TrafficReturn $trafficReturn): TrafficReturn;

}
