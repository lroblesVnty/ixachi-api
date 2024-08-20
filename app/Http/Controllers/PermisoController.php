<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Levantamiento;
use App\Models\Linea;
use App\Models\Permiso;
use App\Models\Predio;
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

    public function prediosLev() {
        $permisoLevan=Levantamiento::select(['IdPermiso'])->get();
        $lineasP=Linea::select(['linea'])
        ->where('idProyecto', '=', '2D SUR')
        ->get();

         DB::table('gespermisos')
            ->join('gespredios', 'gespermisos.IdPredio', '=', 'gespredios.IdPredio')
            ->select('gespermisos.IdPermiso', 'gespermisos.IdPredio', 'gesPredios.IdLinea')
            ->where('IdEstatusPerm', 'not like', 3)
            ->whereIn('gesPredios.IdLinea',$lineasP)
            ->whereNotIn('IdPermiso',$permisoLevan)
            ->get();


       // return Permiso::with(['predio:IdPredio,huertos,noParcela,idLinea'])->get();
        return Permiso::with(['predio'=>function(Builder $query){
                $lineasP=Linea::select(['linea'])
                ->where('idProyecto', '=', '2D SUR')
                ->get();
               // $query->select('IdLinea','IdPredio')
                $query->whereIn('IdLinea',$lineasP);
            
            }])
        ->where('IdEstatusPerm', 'not like', 3)
        ->whereNotIn('IdPermiso',$permisoLevan)
        /*->whereNotIn('IdPermiso',function (Builder $query) {
            $query->select('IdPermiso')->from((new Levantamiento)->getTable());
                
        })*/
        ->get();
    }
    


}
