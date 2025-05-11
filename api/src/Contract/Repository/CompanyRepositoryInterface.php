<?php

namespace App\Contract\Repository;

use App\Exception\CompanyNotFoundException;
use App\Entity\Company;

interface CompanyRepositoryInterface
{
    /**
     * @throws CompanyNotFoundException
     */
    public function findById(int $id, bool $throw = true): ?Company;

    /**
     * @throws CompanyNotFoundException
     */
    public function findByDocument(string $document, bool $throw = true): ?Company;

    /**
     * @throws CompanyNotFoundException
     */
    public function findByEmail(string $email, bool $throw = true): ?Company;

    public function create(Company $company, bool $throw = true): ?Company;
}
