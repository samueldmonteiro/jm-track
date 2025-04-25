<?php

namespace App\Infra\Security\JWT;

use App\Domain\Entity\Admin;
use App\Domain\Exceptions\ErrorGenerateAuthToken;
use App\Domain\Security\AuthToken\AuthTokenAdminInterface;
use App\Infra\Mapper\AuthUserMapper;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthAdmin implements AuthTokenAdminInterface
{
    /**
     * @throws ErrorGenerateAuthToken
     */
    public function generateToken(Admin $admin): string
    {
        $model = AuthUserMapper::adminToEloquent($admin);

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
