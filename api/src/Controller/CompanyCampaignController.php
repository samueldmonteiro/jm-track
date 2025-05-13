<?php

namespace App\Controller;

use App\Controller\Rules\Company\CampaignByIdRules;
use App\Controller\Rules\Company\CreateCampaignRules;
use App\Controller\Rules\Company\DeleteCampaignRules;
use App\Controller\Rules\RuleValidator;
use App\Controller\Rules\Company\UpdateCampaignRules;
use App\UseCase\Campaign\Create\CreateCampaign;
use App\UseCase\Campaign\Create\CreateCampaignInput;
use App\UseCase\Campaign\Delete\DeleteCampaign;
use App\UseCase\Campaign\Delete\DeleteCampaignInput;
use App\UseCase\Campaign\Update\UpdateCampaign;
use App\UseCase\Campaign\Update\UpdateCampaignInput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Company;
use App\UseCase\Campaign\FindAllForCompany\FindAllCampaignsForCompany;
use App\UseCase\Campaign\FindAllForCompany\FindAllCampaignsForCompanyInput;
use App\UseCase\Campaign\FindByIdForCompany\FindCampaignByIdForCompany;
use App\UseCase\Campaign\FindByIdForCompany\FindCampaignByIdForCompanyInput;

final class CompanyCampaignController extends BaseController
{
    public function __construct(
        private CreateCampaign $createCampaign,
        private UpdateCampaign $updateCampaign,
        private DeleteCampaign $deleteCampaign,
        private FindCampaignByIdForCompany $findCampaignByIdForCompany,
        private FindAllCampaignsForCompany $findAllCampaignsForCompany
    ) {}

    public function createCampaign(Request $request, RuleValidator $validator): JsonResponse
    {
        $data = array_merge(['companyId' => $this->getCompanyId()], $request->toArray());
        $rules = new CreateCampaignRules($data);

        return $this->handleRequest(
            $validator,
            $rules,
            fn($rules) => $this->createCampaign->execute(
                new CreateCampaignInput(
                    $rules->name,
                    $rules->companyId
                )
            ),
            context: ['json', 'groups' => ['campaign:read']],
            formatResponse: fn($result) => ['campaign' => $result->campaign]
        );
    }

    public function updateCampaign(Request $request, RuleValidator $validator): JsonResponse
    {
        $data = array_merge([
            'companyId' => $this->getCompanyId(),
            'campaignId' => $request->attributes->get('id'),
        ], $request->toArray());

        $rules = new UpdateCampaignRules($data);

        return $this->handleRequest(
            $validator,
            $rules,
            fn($rules) => $this->updateCampaign->execute(
                new UpdateCampaignInput(
                    $rules->companyId,
                    $rules->campaignId,
                    $rules->name,
                )
            ),
            context: ['json', 'groups' => ['campaign:read']],
            formatResponse: fn($result) => ['campaign' => $result->campaign]
        );
    }

    public function deleteCampaign(Request $request, RuleValidator $validator): JsonResponse
    {
        $data = [
            'companyId' => $this->getCompanyId(),
            'campaignId' => $request->attributes->get('id'),
        ];

        $rules = new DeleteCampaignRules($data);

        return $this->handleRequest(
            $validator,
            $rules,
            fn($rules) => $this->deleteCampaign->execute(
                new DeleteCampaignInput(
                    $rules->companyId,
                    $rules->campaignId,
                )
            ),
            formatResponse: fn($result) =>
            ['deleted' => $result->deleted, 'message' => 'Campanha deletada com sucesso']
        );
    }

    public function campaignById(Request $request, RuleValidator $validator): JsonResponse
    {
        $data = [
            'companyId' => $this->getCompanyId(),
            'campaignId' => $request->attributes->get('id'),
        ];

        $rules = new CampaignByIdRules($data);

        return $this->handleRequest(
            $validator,
            $rules,
            fn($rules) => $this->findCampaignByIdForCompany->execute(
                new FindCampaignByIdForCompanyInput(
                    $rules->companyId,
                    $rules->campaignId,
                )
            ),
            context: ['json', 'groups' => ['campaign:read']],
            formatResponse: fn($result) => $result->toArray()
        );
    }

    public function campaignByIdWithTransactions(Request $request, RuleValidator $validator): JsonResponse
    {
        $data = [
            'companyId' => $this->getCompanyId(),
            'campaignId' => $request->attributes->get('id'),
        ];

        $rules = new CampaignByIdRules($data);

        return $this->handleRequest(
            $validator,
            $rules,
            fn($rules) => $this->findCampaignByIdForCompany->execute(
                new FindCampaignByIdForCompanyInput(
                    $rules->companyId,
                    $rules->campaignId,
                )
            ),
            context: ['json', 'groups' => ['campaign:read', 'tTransaction:read', 'tSource:read']],
            formatResponse: fn($result) => $result->toArray()
        );
    }


    public function allCampaigns(): JsonResponse
    {
        $companyId = $this->getCompanyId();

        $campaigns = $this->findAllCampaignsForCompany->execute(
            new FindAllCampaignsForCompanyInput($companyId)
        );

        return $this->jsonSuccess(
            $campaigns->toArray(),
            context: ['json', 'groups' => ['campaign:read', 'tTransaction:read', 'tSource:read']],
        );
    }

    private function getCompanyId(): int
    {
        /** @var Company $company */
        $company = $this->getUser();
        return $company->getId();
    }
}
