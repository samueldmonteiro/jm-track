<?php

namespace App\Controller;

use App\Controller\Rules\AuthAdminRules;
use App\Controller\Rules\RuleValidator;
use App\UseCase\Auth\Company\AuthCompany;
use App\UseCase\Auth\Company\AuthCompanyInput;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class AuthController extends BaseController
{
    public function __construct(
        private AuthCompany $authCompany
    ) {}

    public function authCompany(Request $request, RuleValidator $validator): JsonResponse
    {
        $rules = new AuthAdminRules($request->toArray());

        $errors = $validator->validate($rules);

        if ($errors) {
            return $this->json($errors);
        }

        try {
            $response = $this->authCompany->execute(
                new AuthCompanyInput($rules->document, $rules->password)
            );
            return $this->json($response);
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage(), $e->getCode());
        }
    }
}
