<?php

namespace App\Contract\Service;

use App\Entity\Company;

interface PasswordHasherInterface
{
    public function hashPassword(Company $user, string $plainPassword): string;
    public function verify(Company $user, string $plainPassword): bool;
}