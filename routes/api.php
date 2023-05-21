<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessServiceController;
use App\Http\Controllers\CompanyController;
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
Route::get('/companies/all', [CompanyController::class, 'index']);

Route::middleware(['auth:sanctum'])->group(function (){
    Route::post('companies/{company}/update', [CompanyController::class, 'upload']);
    Route::apiResource('companies', CompanyController::class);
    Route::get('companies/search/{name}', [CompanyController::class, 'search']);
    Route::post('/users/logout', [AuthController::class, 'logout']);
});

/*Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});*/

Route::post('/users/register', [AuthController::class, 'register']);
Route::post('/users/login', [AuthController::class, 'login']);
Route::get('/search', [BusinessServiceController::class, 'search']);

Route::group(['prefix' => 'services'], function () {
    Route::get('/', [BusinessServiceController::class, 'index']);
    Route::post('/', [BusinessServiceController::class, 'store']);
    Route::get('/{id}', [BusinessServiceController::class, 'show']);
    Route::match(['put', 'patch'], '/{id}', [BusinessServiceController::class, 'update']); //('/{id}', [BusinessServiceController::class, 'update']);
    Route::delete('/{id}', [BusinessServiceController::class, 'destroy']);

    // Search business services

});
