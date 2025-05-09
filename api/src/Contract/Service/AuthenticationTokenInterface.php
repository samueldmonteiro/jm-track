<?php

namespace App\Contract\Service;

use App\Entity\Company;

interface AuthenticationTokenInterface
{
    public function createToken(Company $user);
    public function checkToken(string $token);
    public function getUser(): ?Company;
}
