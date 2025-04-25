<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// V1
Route::prefix('v1')->group(function () {

    // auth
    Route::controller(AuthController::class)->prefix('auth')->name('auth.')->group(
        function () {
            Route::post('admin', 'authAdmin')->name('admin');
            Route::post('company', 'authCompany')->name('company');
        }
    );

    //campaign
    Route::controller(CampaignController::class)->prefix('campaign')->name('campaign.')->group(
        function(){
            Route::post('store', 'store')->name('store');
        }
    );


    //tests
    Route::middleware('auth:admin')->get('/teste', function () {
        return response()->json(Auth::user());
    });

    Route::middleware('auth:company')->get('/teste2', function () {
        return response()->json(Auth::user());
    });
});
