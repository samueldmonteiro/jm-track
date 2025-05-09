<?php

namespace App\Http\Controllers;

use App\Application\UseCase\TrafficReturn\FindAllByCompany\FindAllTrafficReturnByCompanyInputDTO;
use App\Application\UseCase\TrafficReturn\FindAllByCompany\FindAllTrafficReturnByCompanyUseCase;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TrafficReturnController extends Controller
{
    public function getAllByCompany(FindAllTrafficReturnByCompanyUseCase $find): JsonResponse
    {
        try {
            $response = $find->execute(
                new FindAllTrafficReturnByCompanyInputDTO
                (Auth::user()->id)
            );
            return $this->jsonSuccess($response);
        } catch (Exception $e) {
            return $this->jsonError($e->getMessage(), 500);
        }
    }
}
