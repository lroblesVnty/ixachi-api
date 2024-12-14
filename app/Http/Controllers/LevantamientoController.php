<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Levantamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreLevantamientoRequest;

class LevantamientoController extends Controller{


     /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLevantamientoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLevantamientoRequest $request){
       
      //  $validator = Validator::make($request->all(), $rules, $messages,$attributes);
        //*agrupar los errores por cada elemento del arreglo 
       
        
        //return  response()->json(["status"=>'todo ok','data'=>$validator->validated()],200);
       /* $requValid=$request->validated();
        $levantamiento = Levantamiento::create([ 
            'fechaLevantamiento' => $requValid->fechaLev, 'observaciones' => $requValid->observaciones, 
            'idPermiso' => $requValid->idPermiso,'idPersonal'=>57, 
            'imgUrl' => '','numFiniquito'=>$requValid->finiquito, 
        ]);*/
        return  response()->json(["status"=>'todo ok',"data"=>$request->validated()],200);

    }
    
    public function permiso(){
        $permisos=Levantamiento::with('permiso:IdPermiso,fechaPermiso,numPermiso')->get(['IdLevantamiento','fechaLevantamiento','numFiniquito','IdPermiso']);
        return $permisos;
    }
}
