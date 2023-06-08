<?php

use App\Http\Controllers\general\GeneralController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('v1')->group(function () {
    Route::controller(GeneralController::class)->group(function () {
        Route::get('/portfolios', 'portfolios');
        Route::get('/services', 'services');
        Route::get('/about', 'aboutUs');
        Route::get('/general-data', 'generalData');
        Route::get('/seo', 'seo');
        Route::get('/portfolios/{key}', 'portfolioDetail');
        Route::get('/services/{key}', 'serviceDetail');
        Route::post('/contact', 'contactPost')->middleware('checkTokenApi');
        Route::get('/partners', 'partners');

    });
});

/*Route::get('/'.trans('route.services').'/{slug}', 'serviceDetail');
Route::get('/services/{slug}', 'serviceDetail');*/
//Route::get('{lang}/'.__().'/{slug}');
//;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

