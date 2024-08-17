<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Levantamiento;
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
     
        //Permiso::with(['predio:IdPredio,huertos,noParcela,idLinea'])
        Permiso::with(['predio'=>function(Builder $query){
            $lineas=DB::table('gesconfiguracionlineas')
            ->select('linea')
            ->where('idProyecto', '2D SUR') ->get();
                $query->select('IdLinea')
                ->whereIn('IdLinea',$lineas);
            
            }])
        ->where('IdEstatusPerm', 'not like', 2)
        ->whereNotIn('IdPermiso',$permisoLevan)
        /*->whereNotIn('IdPermiso',function (Builder $query) {
            $query->select('IdPermiso')->from((new Levantamiento)->getTable());
                
        })*/
        ->get();
    }
    


}
