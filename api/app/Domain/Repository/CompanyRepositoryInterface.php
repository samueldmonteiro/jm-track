<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Company;

interface CompanyRepositoryInterface
{
    public function findById(int $idm, array $with = []): ?Company;
    public function findByDocument(string $document, array $with = []): ?Company;
    public function campaignBelongsToCompany(int $campaignId, int $companyId): bool;
}
