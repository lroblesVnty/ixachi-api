<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Predio;
use Illuminate\Http\Request;

class PredioController extends Controller
{
    public function permiso(){
        $permisos=Predio::with('permiso:IdPermiso,fechaPermiso,numPermiso,IdPredio')->get(['IdPredio','huertos','noParcela','IdPropietario']);
        return $permisos;
    }

}
