<?php

namespace App\Application\UseCase\Auth\AuthCompany;

use App\Domain\Entity\Company;

class AuthCompanyOutputDTO
{
    public function __construct(
        public string $token,
        public array|Company $user,
        public string $type = 'company'
    ) {
        $this->user = $user->toArray();
    }
}
