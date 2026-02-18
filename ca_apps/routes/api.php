<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProspectionClientController;

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

// Route::resource('addProspect', 'Api\ProspectionClientController@addProspect');
Route::post('addProspect',[ProspectionClientController::class, 'addProspect']);

Route::post('loginprospect',[ProspectionClientController::class, 'loginprospect']);

Route::get('get_canal_list',[ProspectionClientController::class, 'get_canal_list']);


// Route::resource('addProspect', 'Api\ProspectionClientController@addProspect');
