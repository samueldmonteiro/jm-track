<?php

namespace App\Http\Controllers;

use App\Application\UseCase\TrafficReturn\FindAllByCompany\FindAllTrafficReturnByCompanyInputDTO;
use App\Application\UseCase\TrafficReturn\FindallWithTotalAmountByCompany\FindAllTrafficReturnWithTotalAmountByCompanyInputDTO;
use App\Application\UseCase\TrafficReturn\FindallWithTotalAmountByCompany\FindAllTrafficReturnWithTotalAmountByCompanyUseCase;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TrafficReturnController extends Controller
{
    public function getAllByCompany(FindAllTrafficReturnWithTotalAmountByCompanyUseCase $find): JsonResponse
    {
        try {
            $response = $find->execute(
                new FindAllTrafficReturnWithTotalAmountByCompanyInputDTO(Auth::user()->id)
            );
            return $this->jsonSuccess($response);
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage(), 500);
        }
    }
}
