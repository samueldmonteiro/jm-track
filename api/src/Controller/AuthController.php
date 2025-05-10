<?php

namespace App\Controller;

use App\Controller\Rules\AuthAdminRules;
use App\Controller\Rules\RuleValidator;
use App\UseCase\Auth\Company\AuthCompany;
use App\UseCase\Auth\Company\AuthCompanyInput;
use App\UseCase\Auth\GetUser\GetUser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Exception;

final class AuthController extends BaseController
{
    public function __construct(
        private AuthCompany $authCompany,
        private GetUser $getUser,
    ) {}

    public function authCompany(Request $request, RuleValidator $validator): JsonResponse
    {
        $rules = new AuthAdminRules($request->toArray());

        return $this->handleRequest(
            $validator,
            $rules,
            fn($rules) => $this->authCompany->execute(
                new AuthCompanyInput($rules->document, $rules->password)
            ),
            context: ['groups' => ['company_read']],
            formatResponse: fn($result) => [
                'company' => $result->company,
                'token' => $result->token,
            ]
        );
    }

    public function user(): JsonResponse
    {
        try {
            $response = $this->getUser->execute();
            return $this->json($response);
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage(), $e->getCode());
        }
    }

    public function verify(): JsonResponse
    {
        return $this->json(['verify' => $this->getUser() ? true : false]);
    }
}
