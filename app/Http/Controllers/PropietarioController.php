<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Levantamiento;
use App\Models\Linea;
use App\Models\Propietario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropietarioController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $propietarios=Propietario::all();
        return $propietarios;
    }

    public function predios(){
        $predios=Propietario::with('predios:IdPredio,huertos,noParcela,IdPropietario')->get();
        return $predios;
    }

    public function permisosPred(){
        $lineas=Linea::select(['linea'])
        ->where('idProyecto', '=', '2D NORTE')
        ->get();
        $permisoLevan=Levantamiento::select(['IdPermiso'])->get();
        return Propietario::withWhereHas('predios', function ($query) use ($lineas,$permisoLevan){
            $query->withWhereHas ('permiso',function ($q) use ($permisoLevan){
                //$q->select('IdPropietario',DB::raw("CONCAT_WS(' ', nombre, apPaterno, apMaterno) AS nombre"));  
                $q->where('IdEstatusPerm', 'not like', 3);
                $q->whereNotIn('IdPermiso',$permisoLevan );     

                
            });
            $query->select('IdLinea','IdPredio','IdPropietario');
            $query->whereIn('IdLinea',$lineas);

        })
        /*->where('IdEstatusPerm', 'not like', 3)
        ->whereNotIn('IdPermiso',$permisoLevan)*/
        ->get();
        //->get(['IdPermiso','numPermiso','IdPredio']);
    }

    public function propExpedienteComp(){
       // return Propietario::withWhereHas('predios:IdPredio,IdPropietario')

       return DB::table('gescontabilidadestatus')
       ->join('gespermisos', 'gescontabilidadestatus.IdPermiso', '=', 'gespermisos.IdPermiso')
       ->join('gespredios', 'gespermisos.IdPredio', '=', 'gespredios.IdPredio')
       ->join('gespropietarios', 'gespredios.IdPropietario','gespropietarios.IdPropietario')
       ->join('gescatstatusconta', 'gescontabilidadestatus.idCatEstatusConta','gescatstatusconta.idStatusConta')
       ->join('gesconfiguracionlineas', 'gespredios.idLinea','gesconfiguracionlineas.linea')
       ->select('idContabilidadEstatus','gespermisos.IdPermiso', 'gespermisos.IdPredio', 'gesPredios.IdLinea',DB::raw("CONCAT_WS(' ', nombre, apPaterno, apMaterno) AS propietario"),'RFC','nombreStatus','IdLinea','idProyecto')
       ->orderBy('propietario')
       ->get();


        return Propietario::withWhereHas('predios',function ($q){
            $q->select('IdPropietario','IdPredio');  

        })
        //->join('gespermisos', 'gespermisos.IdPredio', '=', 'gespredios.IdPredio')
        ->select('IdPropietario',DB::raw("CONCAT_WS(' ', nombre, apPaterno, apMaterno) AS nombre"),'domicilio','rfc')//checfar consulta para cpntabilidad
        ->get();
        
    }
}
