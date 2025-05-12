<?php

namespace App\Controller;

use App\Controller\Rules\Company\CreateTrafficTransactionRules;
use App\Controller\Rules\Company\DeleteTrafficTransactionRules;
use App\Controller\Rules\RuleValidator;
use App\Controller\Rules\Company\UpdateTrafficTransactionRules;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Company;
use App\Entity\Enum\TrafficTransactionType;
use App\UseCase\TrafficTransaction\Create\CreateTrafficTransaction;
use App\UseCase\TrafficTransaction\Create\CreateTrafficTransactionInput;
use App\UseCase\TrafficTransaction\Delete\DeleteTrafficTransaction;
use App\UseCase\TrafficTransaction\Delete\DeleteTrafficTransactionInput;
use App\UseCase\TrafficTransaction\FindAllForCompany\FindAllTrafficTransactionsForCompany;
use App\UseCase\TrafficTransaction\FindAllForCompany\FindAllTrafficTransactionsForCompanyInput;
use App\UseCase\TrafficTransaction\Update\UpdateTrafficTransaction;
use App\UseCase\TrafficTransaction\Update\UpdateTrafficTransactionInput;
use DateTimeImmutable;

final class CompanyTrafficTransactionController extends BaseController
{
    public function __construct(
        private CreateTrafficTransaction $createTrafficTransaction,
        private UpdateTrafficTransaction $updateTrafficTransaction,
        private DeleteTrafficTransaction $deleteTrafficTransaction,
        private FindAllTrafficTransactionsForCompany $findAllTrafficTransactionsForCompany
    ) {}

    public function createTrafficTransaction(Request $request, RuleValidator $validator): JsonResponse
    {
        $data = array_merge(['companyId' => $this->getCompanyId()], $request->toArray());
        $rules = new CreateTrafficTransactionRules($data);

        return $this->handleRequest(
            $validator,
            $rules,
            fn($rules) => $this->createTrafficTransaction->execute(
                new CreateTrafficTransactionInput(
                    $rules->companyId,
                    $rules->campaignId,
                    $rules->trafficSourceId,
                    $rules->amount,
                    new DateTimeImmutable($rules->date),
                    TrafficTransactionType::tryFrom($rules->type)
                )
            ),
            context: ['json', 'groups' => ['tRead', 'tSource']],
            formatResponse: fn($result) => $result->toArray()
        );
    }

    public function updateTrafficTransaction(Request $request, RuleValidator $validator): JsonResponse
    {
        $data = array_merge([
            'companyId' => $this->getCompanyId(),
            'trafficTransactionId' => $request->attributes->get('id'),
        ], $request->toArray());

        $rules = new UpdateTrafficTransactionRules($data);

        return $this->handleRequest(
            $validator,
            $rules,
            fn($rules) => $this->updateTrafficTransaction->execute(
                new UpdateTrafficTransactionInput(
                    $rules->companyId,
                    $rules->trafficTransactionId,
                    $rules->trafficSourceId,
                    $rules->amount,
                    new DateTimeImmutable($rules->date)
                )
            ),
            context: ['json', 'groups' => ['tRead', 'tSource']],
            formatResponse: fn($result) => $result->toArray()
        );
    }

    public function deleteTrafficTransaction(Request $request, RuleValidator $validator): JsonResponse
    {
        $data = [
            'companyId' => $this->getCompanyId(),
            'trafficTransactionId' => $request->attributes->get('id'),
        ];

        $rules = new DeleteTrafficTransactionRules($data);

        return $this->handleRequest(
            $validator,
            $rules,
            fn($rules) => $this->deleteTrafficTransaction->execute(
                new DeleteTrafficTransactionInput(
                    $rules->companyId,
                    $rules->trafficTransactionId,
                )
            ),
            formatResponse: fn($result) => $result
        );
    }

    public function allTrafficTransactions(): JsonResponse
    {
        $companyId = $this->getCompanyId();

        $trafficTransactions = $this->findAllTrafficTransactionsForCompany->execute(
            new FindAllTrafficTransactionsForCompanyInput($companyId)
        );

        return $this->json(
            $trafficTransactions->toArray(),
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
