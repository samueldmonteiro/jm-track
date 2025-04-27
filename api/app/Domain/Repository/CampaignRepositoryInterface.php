<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Campaign;
use App\Domain\Entity\Company;

interface CampaignRepositoryInterface
{
    public function findById(int $id, array $with = []): ?Campaign;
    public function findByCompany(Company $company, array $with = []): array;

    public function store(Campaign $campaign): Campaign;
    public function delete(int $id): bool;
    public function update(Campaign $campaign): Campaign;
}
