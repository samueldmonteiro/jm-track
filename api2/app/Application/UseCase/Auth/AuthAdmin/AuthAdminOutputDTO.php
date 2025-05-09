<?php

namespace App\Application\UseCase\Auth\AuthAdmin;

class AuthAdminOutputDTO
{
    public function __construct(
        public string $token,
    ) {}
}
