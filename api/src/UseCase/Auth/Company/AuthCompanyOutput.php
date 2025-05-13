<?php

namespace App\UseCase\Auth\Company;

use App\Entity\Company;

class AuthCompanyOutput
{
    private string $userType = 'company';

    public function __construct(
        public string $token,
        public Company $user
    ) {}

    public function toArray(): array
    {
        return [
            'token' => $this->token,
            'user' => $this->user,
            'userType' => $this->userType,
        ];
    }
}
