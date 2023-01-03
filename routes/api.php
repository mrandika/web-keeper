<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login'])->name('api.auth.login');

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('profile', [\App\Http\Controllers\Api\AuthController::class, 'profile'])->name('api.auth.profile');

    Route::group(['prefix' => 'item'], function () {
        Route::get('', [\App\Http\Controllers\Api\Feature\ItemController::class, 'index'])
            ->middleware('log:GET')
            ->name('api.item.index');
        Route::post('store', [\App\Http\Controllers\Api\Feature\ItemController::class, 'store'])
            ->middleware('log:POST')
            ->name('api.item.store');
        Route::post('update/{item_id}', [\App\Http\Controllers\Api\Feature\ItemController::class, 'update'])
            ->middleware('log:POST')
            ->name('api.item.update');
        Route::delete('destroy/{item_id}', [\App\Http\Controllers\Api\Feature\ItemController::class, 'destroy'])
            ->middleware('log:DELETE')
            ->name('api.item.destroy');

        Route::group(['prefix' => 'location'], function () {
            Route::post('store', [\App\Http\Controllers\Api\Feature\ItemLocationController::class, 'store'])
                ->middleware('log:POST')
                ->name('api.item.location.store');
            Route::post('update/{location_id}', [\App\Http\Controllers\Api\Feature\ItemLocationController::class, 'update'])
                ->middleware('log:POST')
                ->name('api.item.location.update');
            Route::delete('destroy', [\App\Http\Controllers\Api\Feature\ItemLocationController::class, 'destroy'])
                ->middleware('log:DELETE')
                ->name('api.item.location.destroy');
        });
    });
});
