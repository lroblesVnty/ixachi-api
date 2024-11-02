<?php

use App\Http\Controllers\CultivoController;
use App\Http\Controllers\EstacaController;
use App\Http\Controllers\LevantamientoController;
use App\Http\Controllers\LineaController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\PredioController;
use App\Http\Controllers\PropietarioController;
use App\Http\Controllers\ProyectoController;
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
Route::get('propietario/permisos',[PropietarioController::class,'permisosPred']);

Route::get('permiso',[PermisoController::class,'index']);
Route::get('permiso/predio',[PermisoController::class,'predio']);
Route::get('permiso/lev/{proyecto}',[PermisoController::class,'permForLev']);
Route::get('permiso/{permiso}',[PermisoController::class,'detallePermiso']);

Route::get('predio/permiso',[PredioController::class,'permiso']);
Route::get('predio/propietario',[PredioController::class,'predioProp']);

Route::get('levantamiento/permiso',[LevantamientoController::class,'permiso']);

Route::get('proyecto',[ProyectoController::class,'index']);
Route::get('proyecto/dept',[ProyectoController::class,'proyByDept']);

Route::get('linea',[LineaController::class,'lineaByProyTipo']);
Route::get('linea/distancia/{linea}',[LineaController::class,'distanciaByLinea']);

Route::get('cultivos',[CultivoController::class,'index']);

Route::get('estacas',[EstacaController::class,'estacasbylinea']);
Route::get('estacaFinal',[EstacaController::class,'getEstacaFinal']);
