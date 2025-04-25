<?php

namespace App\Domain\Security\AuthToken;

use App\Domain\Entity\Admin;
use App\Domain\Entity\Company;

interface AuthTokenCompanyInterface extends AuthTokenInterface
{
    /**
     * @throws ErrorGenerateAuthToken
     */
    public function generateToken(Company $company): string;
}
