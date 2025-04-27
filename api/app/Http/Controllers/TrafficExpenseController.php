<?php

namespace App\Http\Controllers;

use App\Application\UseCase\TrafficExpense\FindByCompany\FindTrafficExpensesByCompanyInputDTO;
use App\Application\UseCase\TrafficExpense\FindByCompany\FindTrafficExpensesByCompanyUseCase;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TrafficExpenseController extends Controller
{
    public function byCompany(FindTrafficExpensesByCompanyUseCase $find): JsonResponse
    {
        try {
            $response = $find->execute(
                new FindTrafficExpensesByCompanyInputDTO(Auth::user()->id)
            );
            return $this->jsonSuccess($response);
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage(), 500);
        }
    }
}
