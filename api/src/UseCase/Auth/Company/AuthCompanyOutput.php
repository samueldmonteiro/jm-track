<?php

namespace App\UseCase\Auth\Company;

use App\Entity\Company;

class AuthCompanyOutput
{
    public function __construct(
        public string $token,
        public Company $company
    ) {}
}
