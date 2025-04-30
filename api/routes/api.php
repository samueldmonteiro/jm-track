<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\TrafficExpenseController;
use App\Http\Controllers\TrafficSourceController;
use App\Http\Middleware\DetectUserType;
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
    Route::middleware('auth:company')->controller(CampaignController::class)->prefix('campaigns')->name('campaign.')->group(
        function(){
            Route::post('store', 'store')->name('store');
            Route::delete('delete/{id}', 'delete')->name('delete');
            Route::get('company/{id}', 'findCampaignsbyCompany')->name('findByCompany');
            Route::put('update/{id}', 'update')->name('update');
        }
    );

    // traffic source
    Route::middleware(DetectUserType::class)->controller(TrafficSourceController::class)->prefix('traffic_sources')->name('traffic_source.')->group(
        function(){
            Route::get('/', 'getAll')->name('all');
        }
    );

    // traffic expense
    Route::middleware(DetectUserType::class)->controller(TrafficExpenseController::class)->prefix('traffic_expenses')->name('traffic_expense.')->group(
        function(){
            Route::get('/', 'byCompany')->name('byCompany');
            Route::post('store', 'store')->name('store');
        }
    );

    // tests
    Route::middleware('auth:admin')->get('/teste', function () {
        return response()->json(Auth::user());
    });

    Route::middleware('auth:company')->get('/teste2', function () {
        return response()->json(Auth::user());
    });
});
