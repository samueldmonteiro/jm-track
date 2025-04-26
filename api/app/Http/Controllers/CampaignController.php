<?php

namespace App\Http\Controllers;

use App\Application\UseCase\Campaign\FindCampaignsForCompany\FindCampaignsForCompanyUseCase;
use App\Application\UseCase\Campaign\Delete\CampaignDeleteInputDTO;
use App\Application\UseCase\Campaign\Delete\CampaignDeleteUseCase;
use App\Application\UseCase\Campaign\FindCampaignsForCompany\FindCampaignsForCompanyInputDTO;
use App\Application\UseCase\Campaign\Store\CampaignStoreInputDTO;
use App\Application\UseCase\Campaign\Store\CampaignStoreUseCase;
use App\Application\UseCase\Campaign\Update\CampaignUpdateInputDTO;
use App\Application\UseCase\Campaign\Update\CampaignUpdateUseCase;
use App\Http\Requests\CampaignStoreRequest;
use App\Http\Requests\CampaignUpdateRequest;
use DateTimeImmutable;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    public function store(CampaignStoreRequest $request, CampaignStoreUseCase $store): JsonResponse
    {
        $dto = new CampaignStoreInputDTO(
            Auth::user()->id,
            $request->validated('name'),
            new DateTimeImmutable($request->validated('startDate')),
            new DateTimeImmutable($request->validated('endDate')),
        );

        try {
            $response = $store->execute($dto);

            return $this->jsonSuccess($response->toArray());
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage(), 500);
        }
    }

    public function delete(int $id, CampaignDeleteUseCase $delete): JsonResponse
    {
        try {
            $response = $delete->execute(
                new CampaignDeleteInputDTO(Auth::user()->id, $id)
            );

            return $this->jsonSuccess($response);
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage(), $e->getCode() ?? 500);
        }
    }

    public function findCampaignsbyCompany(int $id, FindCampaignsForCompanyUseCase $useCase): JsonResponse
    {
        try {
            $response = $useCase->execute(
                new FindCampaignsForCompanyInputDTO($id)
            );

            return $this->jsonSuccess($response);
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage(), $e->getCode());
        }
    }

    public function update(int $id, CampaignUpdateRequest $request, CampaignUpdateUseCase $update): JsonResponse
    {
        try {
            $response = $update->execute(
                new CampaignUpdateInputDTO(Auth::user()->id, $id, $request->validated('name'))
            );

            return $this->jsonSuccess($response);
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage(), $e->getCode());
        }
    }
}
