<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Company;

interface CompanyRepositoryInterface
{
    public function findById(int $id): ?Company;
    public function findByDocument(string $document): ?Company;
}
