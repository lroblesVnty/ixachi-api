<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Levantamiento;
use App\Models\Linea;
use App\Models\Permiso;
use App\Models\Predio;
use Illuminate\Database\Eloquent\Builder;
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

    public function prediosLev($proyecto) {
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
        return Permiso::withWhereHas('predio', function ($query) use ($lineas){
            $query->with('propietario',function ($q){
                $q->select('IdPropietario',DB::raw("CONCAT_WS(' ', nombre, apPaterno, apMaterno) AS nombre"));
            });
            $query->select('IdLinea','IdPredio','IdPropietario');
            $query->whereIn('IdLinea',$lineas);

        })
        ->where('IdEstatusPerm', 'not like', 3)
        ->whereNotIn('IdPermiso',$permisoLevan)
        ->get(['IdPermiso','numPermiso','IdPredio']);

        
        /*Permiso::whereHas('predio', function (Builder $query) {
            $query->select('IdLinea','IdPredio');
        })->get();*/
        

        DB::table('gespermisos')
        ->join('gespredios', 'gespermisos.IdPredio', '=', 'gespredios.IdPredio')
        ->join('gespropietarios', 'gespredios.IdPredio', '=', 'gespropietarios.IdPropietario')
        ->select('gespermisos.IdPermiso', 'gespermisos.IdPredio', 'gesPredios.IdLinea',DB::raw("CONCAT_WS(' ', nombre, apPaterno, apMaterno) AS nombre"))
        ->where('IdEstatusPerm', 'not like', 3)
        ->whereIn('gesPredios.IdLinea',$lineas)
        ->whereNotIn('IdPermiso',$permisoLevan)
        ->get();


     
    
    }

}
