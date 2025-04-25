<?php

namespace App\Domain\Security\AuthToken;

use App\Domain\Entity\Admin;

interface AuthTokenAdminInterface extends AuthTokenInterface
{
    /**
     * @throws ErrorGenerateAuthToken
     */
    public function generateToken(Admin $admin): string;
}
