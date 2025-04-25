<?php

namespace App\Application\UseCase\Auth\AuthCompany;

class AuthCompanyInputDTO
{
    public function __construct(
        public string $document,
        public string $password
    ) {}
}
