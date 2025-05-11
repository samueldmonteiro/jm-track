<?php

namespace App\Controller;

use App\Controller\Rules\Company\CampaignByIdRules;
use App\Controller\Rules\Company\CreateCampaignRules;
use App\Controller\Rules\Company\CreateTrafficReturnRules;
use App\Controller\Rules\Company\DeleteCampaignRules;
use App\Controller\Rules\Company\DeleteTrafficReturnRules;
use App\Controller\Rules\RuleValidator;
use App\Controller\Rules\Company\UpdateCampaignRules;
use App\Controller\Rules\Company\UpdateTrafficReturnRules;
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
use App\UseCase\TrafficReturn\Create\CreateTrafficReturn;
use App\UseCase\TrafficReturn\Create\CreateTrafficReturnInput;
use App\UseCase\TrafficReturn\Delete\DeleteTrafficReturn;
use App\UseCase\TrafficReturn\Delete\DeleteTrafficReturnInput;
use App\UseCase\TrafficReturn\FindAllForCompany\FindAllTrafficReturnsForCompany;
use App\UseCase\TrafficReturn\FindAllForCompany\FindAllTrafficReturnsForCompanyInput;
use App\UseCase\TrafficReturn\Update\UpdateTrafficReturn;
use App\UseCase\TrafficReturn\Update\UpdateTrafficReturnInput;
use DateTimeImmutable;

final class CompanyTrafficReturnController extends BaseController
{
    public function __construct(
        private CreateCampaign $createCampaign,
        private UpdateCampaign $updateCampaign,
        private DeleteCampaign $deleteCampaign,

        private CreateTrafficReturn $createTrafficReturn,
        private UpdateTrafficReturn $updateTrafficReturn,
        private DeleteTrafficReturn $deleteTrafficReturn,
        private FindCampaignByIdForCompany $findCampaignByIdForCompany,
        private FindAllCampaignsForCompany $findAllCampaignsForCompany,

        private FindAllTrafficReturnsForCompany $findAllTrafficReturnsForCompany
    ) {}

    public function createTrafficReturn(Request $request, RuleValidator $validator): JsonResponse
    {
        $data = array_merge(['companyId' => $this->getCompanyId()], $request->toArray());
        $rules = new CreateTrafficReturnRules($data);

        return $this->handleRequest(
            $validator,
            $rules,
            fn($rules) => $this->createTrafficReturn->execute(
                new CreateTrafficReturnInput(
                    $rules->companyId,
                    $rules->campaignId,
                    $rules->trafficSourceId,
                    $rules->amount,
                    new DateTimeImmutable($rules->date)
                )
            ),
            context: ['json', 'groups' => ['tRead', 'tSource']],
            formatResponse: fn($result) => $result->toArray()
        );
    }

    public function updateTrafficReturn(Request $request, RuleValidator $validator): JsonResponse
    {
        $data = array_merge([
            'companyId' => $this->getCompanyId(),
            'trafficReturnId' => $request->attributes->get('id'),
        ], $request->toArray());

        $rules = new UpdateTrafficReturnRules($data);

        return $this->handleRequest(
            $validator,
            $rules,
            fn($rules) => $this->updateTrafficReturn->execute(
                new UpdateTrafficReturnInput(
                    $rules->companyId,
                    $rules->trafficReturnId,
                    $rules->trafficSourceId,
                    $rules->amount,
                    new DateTimeImmutable($rules->date)
                )
            ),
            context: ['json', 'groups' => ['tRead', 'tSource']],
            formatResponse: fn($result) => $result->toArray()
        );
    }

    public function deleteTrafficReturn(Request $request, RuleValidator $validator): JsonResponse
    {
        $data = [
            'companyId' => $this->getCompanyId(),
            'trafficReturnId' => $request->attributes->get('id'),
        ];

        $rules = new DeleteTrafficReturnRules($data);

        return $this->handleRequest(
            $validator,
            $rules,
            fn($rules) => $this->deleteTrafficReturn->execute(
                new DeleteTrafficReturnInput(
                    $rules->companyId,
                    $rules->trafficReturnId,
                )
            ),
            formatResponse: fn($result) => $result
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
            context: ['json', 'groups' => ['campaign_read']],
            formatResponse: fn($result) => $result->toArray()
        );
    }

    public function allTrafficReturns(): JsonResponse
    {
        $companyId = $this->getCompanyId();

        $trafficReturns = $this->findAllTrafficReturnsForCompany->execute(
            new FindAllTrafficReturnsForCompanyInput($companyId)
        );

        return $this->json(
            $trafficReturns->toArray(),
            context: ['json', 'groups' => ['tReturn', 'tSource']],
        );
    }

    private function getCompanyId(): int
    {
        /** @var Company $company */
        $company = $this->getUser();
        return $company->getId();
    }
}
