<?php

namespace App\UseCase\Auth\Company;

class AuthCompanyOutput
{
    public function __construct(
        public $token,
        public $company
    ) {}
}
