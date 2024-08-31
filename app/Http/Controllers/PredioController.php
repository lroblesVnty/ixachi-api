<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Predio;
use App\Models\Propietario;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PredioController extends Controller{
    

    public function permiso(){
        $permisos=Predio::with('permiso:IdPermiso,fechaPermiso,numPermiso,IdPredio')->get(['IdPredio','huertos','noParcela','IdPropietario']);
        return $permisos;
    }

    public function predioProp(){
        /*return Predio::addSelect(['Propietario' => Propietario::select('nombre')
            ->whereColumn('IdPropietario', 'gespredios.IdPropietario')
        ])->get();*/
       /* Predio::with(['propietario'])
        ->orderBy(Propietario::select('nombre')->whereColumn('gespredios.IdPropietario','gespropietarios.IdPropietario'))
        ->get(); //*  obtener predios con propietarios, ordenados por el nombre del propietario 
         */ 
        return Predio::with(['permiso'=>function(Builder $query){
            $query->where('IdEstatusPerm','like',2);
           // $query->where('IdEstatusPerm','not in','3');
            $query->select('IdPermiso','numPermiso','IdPredio');
        }
        ,'propietario:IdPropietario,nombre,apPaterno,apMaterno'])->get(['IdPredio','huertos','noParcela','IdPropietario']);
    }

}
