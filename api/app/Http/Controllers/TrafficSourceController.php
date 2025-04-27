<?php

namespace App\Http\Controllers;

use App\Application\UseCase\TrafficSource\GetAll\TrafficSourceGetAllUseCase;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrafficSourceController extends Controller
{
    public function getAll(Request $request, TrafficSourceGetAllUseCase $getAll): JsonResponse
    {
        try {
            $response = $getAll->execute($request->limit ?? 10);
            return $this->jsonSuccess(
                array_map(function($ts){
                    return $ts->toArray();
                }, $response)
            );

        } catch (Exception $e) {
            return $this->jsonError($e->getMessage(), 500);
        } 
    }
}
