<?php

namespace App\Infra\Security\JWT;

use App\Domain\Entity\Admin;
use App\Domain\Entity\Company;
use App\Domain\Exceptions\ErrorGenerateAuthToken;
use App\Domain\Security\AuthToken\AuthTokenCompanyInterface;
use App\Infra\Mapper\AuthUserMapper;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthCompany implements AuthTokenCompanyInterface
{
    /**
     * @throws ErrorGenerateAuthToken
     */
    public function generateToken(Company $company): string
    {
        $model = AuthUserMapper::companyToEloquent($company);

        try {
            return JWTAuth::fromUser($model);
        } catch (\Exception) {
            throw new ErrorGenerateAuthToken('error ao gerar token de autenticação', 500);
        }
    }

    public function verifyToken(string $token): bool
    {
        return Auth::check();
    }

    public function getToken(): string
    {
        return JWTAuth::getToken();
    }
}
