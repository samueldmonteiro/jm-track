<?php

namespace App\Controller;

use App\Controller\Rules\CreateCompanyRules;
use App\Controller\Rules\RuleValidator;
use App\UseCase\Company\Create\CreateCompany;
use App\UseCase\Company\Create\CreateCompanyInput;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class CompanyController extends BaseController
{
    public function __construct(
        private CreateCompany $create
    ) {}

    public function store(Request $request, RuleValidator $validator): JsonResponse
    {
        $rules = new CreateCompanyRules($request->toArray());
        $errors = $validator->validate($rules);
        if ($errors) {
            return $this->json($errors);
        }

        try {
            $response = $this->create->execute(
                new CreateCompanyInput(
                    $rules->name,
                    $rules->document,
                    $rules->phone,
                    $rules->email,
                    $rules->password
                )
            );
            return $this->json($response);
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage(), $e->getCode());
        }
    }
}
