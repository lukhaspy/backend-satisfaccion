<?php

use App\Http\Controllers\SatisfaccionController;
use App\Http\Controllers\UserController;
use App\Models\Satisfaccion;
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

Route::post('satisfaccion', [SatisfaccionController::class, 'store']);
Route::post('login', [UserController::class, 'login'])->name('login');
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('satisfaccion', [SatisfaccionController::class, 'index']);
    Route::get('satisfaccion/grafico', [SatisfaccionController::class, 'getGrafico']);
    Route::get('logout', [UserController::class, 'logout']);
});
