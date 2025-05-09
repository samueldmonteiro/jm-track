<?php

namespace App\UseCase\Auth\Company;

class AuthCompanyInput
{
    public function __construct(
        public string $document,
        public string $password,
    ) {}
}
