<?php

namespace App\Controller;

use App\Controller\Rules\Company\CreateCompanyRules;
use App\Controller\Rules\RuleValidator;
use App\UseCase\Campaign\Create\CreateCampaign;
use App\UseCase\Company\Create\CreateCompany;
use App\UseCase\Company\Create\CreateCompanyInput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class CompanyController extends BaseController
{
    public function __construct(
        private CreateCompany $createCompany,
        private CreateCampaign $createCampaign,
    ) {}

    public function store(Request $request, RuleValidator $validator): JsonResponse
    {
        $rules = new CreateCompanyRules($request->toArray());

        return $this->handleRequest(
            $validator,
            $rules,
            fn($rules) => $this->createCompany->execute(
                new CreateCompanyInput(
                    $rules->name,
                    $rules->document,
                    $rules->phone,
                    $rules->email,
                    $rules->password
                )
            )
        );
    }
}