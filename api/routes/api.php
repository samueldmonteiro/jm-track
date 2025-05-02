<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\TrafficExpenseController;
use App\Http\Controllers\TrafficReturnController;
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
            Route::post('user', 'getUser')->middleware(DetectUserType::class)->name('getUser');

            Route::post('verify', function () {
                return response()->json(['verify' => true]);
            })->middleware(DetectUserType::class)->name('verifyToken');
        }
    );

    Route::middleware('auth:company')->prefix('company')->name('company.')->group(
        function () {

            // traffic source
            Route::controller(TrafficSourceController::class)->prefix('traffic_sources')->name('traffic_source.')->group(
                function () {
                    Route::get('/', 'getAllByCompany')->name('getAllByCompany');
                }
            );

            // traffic expense
            Route::controller(TrafficExpenseController::class)->prefix('traffic_expenses')->name('traffic_expense.')->group(
                function () {
                    Route::get('/', 'getAllByCompany')->name('getAllByCompany');
                    Route::post('store', 'store')->name('store');
                }
            );

            // traffic expense
            Route::controller(TrafficReturnController::class)->prefix('traffic_returns')->name('traffic_return.')->group(
                function () {
                    Route::get('/', 'getAllByCompany')->name('getAllByCompany');
                }
            );

            //campaign
            Route::controller(CampaignController::class)->prefix('campaigns')->name('campaign.')->group(
                function () {
                    Route::post('store', 'store')->name('store');
                    Route::delete('delete/{id}', 'delete')->name('delete');
                    Route::get('/', 'findCampaignsbyCompany')->name('findByCompany');
                    Route::put('update/{id}', 'update')->name('update');
                }
            );
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
