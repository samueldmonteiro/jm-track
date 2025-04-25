<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// V1
Route::prefix('v1')->group(function () {

    // auth
    Route::controller(AuthController::class)->prefix('auth')->group(
        function () {
            Route::post('admin', 'authAdmin');
            Route::post('company', 'authCompany');
        }
    );

    Route::middleware('auth:admin')->get('/teste', function () {
        return response()->json(Auth::user());
    });

    Route::middleware('auth:company')->get('/teste2', function () {
        return response()->json(Auth::user());
    });
});
