<?php

use App\Http\Controllers\LevantamientoController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\PredioController;
use App\Http\Controllers\PropietarioController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('propietario',[PropietarioController::class,'index']);
Route::get('propietario/predios',[PropietarioController::class,'predios']);

Route::get('permiso',[PermisoController::class,'index']);
Route::get('permiso/predio',[PermisoController::class,'predio']);
Route::get('permiso/lev/{proyecto}',[PermisoController::class,'prediosLev']);

Route::get('predio/permiso',[PredioController::class,'permiso']);
Route::get('predio/propietario',[PredioController::class,'predioProp']);

Route::get('levantamiento/permiso',[LevantamientoController::class,'permiso']);

