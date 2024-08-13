<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Permiso;
use App\Models\Predio;
use Illuminate\Http\Request;

class PermisoController extends Controller{
    
    public function index(){
        $predios=Permiso::all();
        return $predios;
    }

    public function predio(){
        $predios=Permiso::with('predio:IdPredio,huertos,noParcela,idLinea')->get(['IdPermiso','fechaPermiso','numPermiso','fechaReporte','IdPredio']);
        return $predios;
    }


}
