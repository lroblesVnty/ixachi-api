<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Levantamiento;
use Illuminate\Http\Request;

class LevantamientoController extends Controller{

    public function store(Request $request){
        $request->validate(
            [
                'fechaLev' => 'required|date_format:d/m/Y',
                'observaciones' => 'nullable|string',
                'idPermiso' => 'required|unique:geslevantamientos,idPermiso|numeric|max_digits:5',
                'idPersonal' => 'required|numeric|exists:catpersonal,IdPersonal|max_digits:5',
                //'imgUrl' => 'required|unique:geslevantamientos,idPermiso',
                //'archivos',
                'finiquito' => 'required|unique:geslevantamientos,numFiniquito|numeric|max_digits:5',
                //TODO agregar los campos del detalle levantamiento
                'detalleLev'=>'required|array',
                'detalleLev.tipoLinea'=>'required'
            ],
            [
                //customMessages
                //'proyecto.required' => 'El campo :attribute es requerido',
            ],
            [
                //custom attributes
                'idPermiso'=>'idPermiso'//se coloco para no separar el campo a= id permiso
            ]
        );
        return  response()->json(["distancia"=>'todo ok'],200);

    }
    
    public function permiso(){
        $permisos=Levantamiento::with('permiso:IdPermiso,fechaPermiso,numPermiso')->get(['IdLevantamiento','fechaLevantamiento','numFiniquito','IdPermiso']);
        return $permisos;
    }
}
