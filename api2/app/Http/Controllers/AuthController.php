<?php

namespace App\Http\Controllers;

use App\Application\UseCase\Auth\AuthAdmin\{AuthAdminInputDTO, AuthAdminUseCase};
use App\Application\UseCase\Auth\AuthCompany\AuthCompanyInputDTO;
use App\Application\UseCase\Auth\AuthCompany\AuthCompanyUseCase;
use App\Application\UseCase\Auth\GetUser\GetUserUseCase;
use App\Application\UseCase\Auth\VerifyAuthToken\VerifyAuthTokenUseCase;
use App\Domain\ValueObject\Email;
use App\Http\Requests\AuthAdminRequest;
use App\Http\Requests\AuthCompanyRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function authAdmin(AuthAdminRequest $request, AuthAdminUseCase $auth): JsonResponse
    {
        try {
            $dto = new AuthAdminInputDTO(new Email($request->email), $request->password);
        } catch (\InvalidArgumentException) {
            return $this->jsonError('Credencial inválida', 401);
        }

        $response = $auth->execute($dto);

        if (!$response || !$response->token) {
            return $this->jsonError('Credencial inválida', 401);
        }

        return $this->jsonSuccess($response->token);
    }

    public function authCompany(AuthCompanyRequest $request, AuthCompanyUseCase $auth): JsonResponse
    {
        $dto = new AuthCompanyInputDTO(
            $request->validated('document'),
            $request->validated('password')
        );

        $response = $auth->execute($dto);

        if (!$response || !$response->token) {
            return $this->jsonError('Credencial inválida', 401);
        }

        return $this->jsonSuccess($response);
    }

    public function getUser(Request $request, GetUserUseCase $get): JsonResponse
    {
        $response = $get->execute($request->bearerToken());

        return $this->jsonSuccess($response);
    }
}
