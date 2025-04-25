<?php

namespace App\Http\Controllers;

use App\Application\UseCase\Campaign\Store\CampaignStoreInputDTO;
use App\Application\UseCase\Campaign\Store\CampaignStoreUseCase;
use App\Http\Requests\CampaignStoreRequest;
use DateTimeImmutable;
use Exception;
use Illuminate\Http\JsonResponse;

class CampaignController extends Controller
{
    public function store(CampaignStoreRequest $request, CampaignStoreUseCase $store): JsonResponse
    {
        $dto = new CampaignStoreInputDTO(
            $request->validated('companyId'),
            $request->validated('name'),
            new DateTimeImmutable($request->validated('startDate')),
            new DateTimeImmutable($request->validated('endDate')),
        );

        try {
            $response = $store->execute($dto);

            return $this->jsonSuccess($response->toArray());
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage(), $e->getCode());
        }
    }
}
