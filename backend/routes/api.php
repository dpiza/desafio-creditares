<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CepController;

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


Route::group(['prefix' => 'cep'], function () {
  Route::get('/', [CepController::class, 'findAll']);
  Route::get('/{cep}', [CepController::class, 'findByCep'])
    ->where('cep', '[0-9]{8}');
  Route::get('/search/{streetName}', [CepController::class, 'findByStreetName']);
  Route::post('/{cep}', [CepController::class, 'store'])
    ->where('cep', '[0-9]{8}');
  // Route::put('/{cep}', [CepController::class, 'update'])
  //   ->where('cep', '[0-9]{8}');
  // Route::delete('/{cep}', [CepController::class, 'destroy'])
  //   ->where('cep', '[0-9]{8}');
});
