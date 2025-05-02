<?php

namespace App\Domain\Security;

use App\Domain\Entity\Admin;
use App\Domain\Entity\Company;

interface AuthTokenInterface
{
    public function verifyToken(string $token): bool;
    public function getToken(): string;
    public function getAuthUser(string $token): Company|Admin;

    /** @throws ErrorGenerateAuthToke */
    public function generateToken(Admin|Company $user): string;
}
