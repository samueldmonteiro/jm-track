<?php

namespace App\Infra\Security\JWT;

use App\Domain\Entity\Admin;
use App\Domain\Entity\Company;
use App\Domain\Exceptions\ErrorGenerateAuthToken;
use App\Domain\Security\AuthTokenInterface;
use App\Infra\EloquentModel\CompanyModel;
use App\Infra\Mapper\AuthUserMapper;
use App\Infra\Mapper\CompanyMapper;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthToken implements AuthTokenInterface
{
    /**
     * @throws ErrorGenerateAuthToken
     */
    public function generateToken(Admin|Company $user): string
    {

        $model = match (true) {
            $user instanceof Admin => AuthUserMapper::adminToEloquent($user),
            $user instanceof Company => AuthUserMapper::companyToEloquent($user),
            default => throw new \InvalidArgumentException('Invalid user type'),
        };

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

    public function getAuthUser(string $token): Company|Admin
    {
        $payload = JWTAuth::setToken($token)->getPayload();
        $role = $payload->get('role');

        $model = Auth::guard($role)->user();

        return match (true) {
            $model instanceof CompanyModel => CompanyMapper::eloquentToCompany($model),
            $model instanceof Admin => $model,
            default => throw new \InvalidArgumentException('Invalid user type'),
        };
    }
}
