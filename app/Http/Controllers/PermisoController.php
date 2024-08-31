<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Levantamiento;
use App\Models\Linea;
use App\Models\Permiso;
use App\Models\Predio;
use App\Models\Propietario;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermisoController extends Controller{
    
    public function index(){
        $predios=Permiso::all();
        return $predios;
    }

    public function predio(){
        $predios=Permiso::with('predio:IdPredio,huertos,noParcela,idLinea')->get(['IdPermiso','fechaPermiso','numPermiso','fechaReporte','IdPredio']);
        return $predios;
    }

    public function permForLev($proyecto) {
        $lineas=Linea::select(['linea'])
        ->where('idProyecto', '=', $proyecto)
        ->get();
        if ($lineas->isEmpty() ) {
            $data = [
                'message' => 'Proyecto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $permisoLevan=Levantamiento::select(['IdPermiso'])->get();
       /* Permiso::withWhereHas('predio.propietario',function($query) {
            $query->select('IdPropietario',DB::raw("CONCAT_WS(' ', nombre, apPaterno, apMaterno) AS nombre"));
        })
        ->get();*/
         Permiso::withWhereHas('predio', function ($query) use ($lineas){
            $query->with('propietario',function ($q){
                $q->select('IdPropietario',DB::raw("CONCAT_WS(' ', nombre, apPaterno, apMaterno) AS nombre"));           

                
            });
            $query->select('IdLinea','IdPredio','IdPropietario');
            $query->whereIn('IdLinea',$lineas);

        })
        ->where('IdEstatusPerm', 'not like', 3)
        ->whereNotIn('IdPermiso',$permisoLevan)
        ->get(['IdPermiso','numPermiso','IdPredio']);
        //->sortBy('predio.propietario.nombre')); // *ordenar por nombre de propietario (consume mas memoria)
        //->sortBy(function ($perm) { return $perm->predio->propietario->nombre; });

        
        /*Permiso::whereHas('predio', function (Builder $query) {
            $query->select('IdLinea','IdPredio');
        })->get();*/
        

        return DB::table('gespermisos')
        ->join('gespredios', 'gespermisos.IdPredio', '=', 'gespredios.IdPredio')
        ->join('gespropietarios', 'gespredios.IdPropietario', '=', 'gespropietarios.IdPropietario')
        ->select('gespermisos.IdPermiso', 'gespermisos.IdPredio', 'gesPredios.IdLinea',DB::raw("CONCAT_WS(' ', nombre, apPaterno, apMaterno) AS propietario"))
        ->where('IdEstatusPerm', 'not like', 3)
        ->whereIn('gesPredios.IdLinea',$lineas)
        ->whereNotIn('IdPermiso',$permisoLevan)
        ->orderBy('propietario')
        ->get();


     
    
    }

    public function detallePermiso($permiso){
        return Permiso::with(['predio'=>function(Builder $query){
            $query->with('propietario',function ($q){
                $q->select('IdPropietario',DB::raw("CONCAT_WS(' ', nombre, apPaterno, apMaterno) AS nombre"));           

                
            });
            //obtnerr el estado u municipio del predio
           // $query->where('IdEstatusPerm','not in','3');
        }])->find($permiso);
    }

}
