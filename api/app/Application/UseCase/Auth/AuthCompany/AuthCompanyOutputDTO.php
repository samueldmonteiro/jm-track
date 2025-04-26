<?php

namespace App\Application\UseCase\Auth\AuthCompany;

class AuthCompanyOutputDTO
{
    public function __construct(
        public string $token
    ) {}
}
