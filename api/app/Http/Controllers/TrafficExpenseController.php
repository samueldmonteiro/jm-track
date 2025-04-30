<?php

namespace App\Http\Controllers;

use App\Application\UseCase\TrafficExpense\FindAllByCompany\FindAllTrafficExpensesByCompanyInputDTO;
use App\Application\UseCase\TrafficExpense\FindAllByCompany\FindAllTrafficExpensesByCompanyUseCase;
use App\Application\UseCase\TrafficExpense\Store\TrafficExpenseStoreInputDTO;
use App\Application\UseCase\TrafficExpense\Store\TrafficExpenseStoreUseCase;
use App\Domain\ValueObject\Amount;
use App\Http\Requests\TrafficExpenseStoreRequest;
use DateTimeImmutable;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TrafficExpenseController extends Controller
{
    public function byCompany(FindAllTrafficExpensesByCompanyUseCase $find): JsonResponse
    {
        try {
            $response = $find->execute(
                new FindAllTrafficExpensesByCompanyInputDTO(Auth::user()->id)
            );
            return $this->jsonSuccess(
                array_map(function ($te) {
                    return $te->toArray();
                }, $response)
            );
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage(), 500);
        }
    }

    public function store(
        TrafficExpenseStoreRequest $request,
        TrafficExpenseStoreUseCase $store
    ): JsonResponse {
        try {
            $response = $store->execute(
                new TrafficExpenseStoreInputDTO(
                    Auth::user()->id,
                    $request->validated('trafficSourceId'),
                    $request->validated('campaignId'),
                    new DateTimeImmutable($request->validated('date')),
                    new Amount($request->validated('amount'))
                )
            );
            return $this->jsonSuccess($response->toArray());
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage(), 500);
        }
    }
}
