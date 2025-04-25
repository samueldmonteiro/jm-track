<?php

namespace App\Application\UseCase\Auth\AuthAdmin;

use App\Domain\ValueObject\Email;

class AuthAdminInputDTO
{
    public function __construct(
        public Email $email,
        public string $password
    ) {}
}
