<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Levantamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LevantamientoController extends Controller{

    public function store(Request $request){
        $rules= [
            'fechaLev' => 'required|date_format:d/m/Y',
            'observaciones' => 'nullable|string',
            'idPermiso' => 'required|unique:geslevantamientos,idPermiso|integer|max_digits:5',
            'idPersonal' => 'required|integer|exists:catpersonal,IdPersonal|max_digits:5',
            //'imgUrl' => 'required|unique:geslevantamientos,idPermiso',
            //'archivos',
            'finiquito' => 'required|unique:geslevantamientos,numFiniquito|numeric|max_digits:5',
            //TODO agregar los campos del detalle levantamiento
            'detalleLev'=>'required|array',
            'detalleLev.*.tipoLinea'=>'required|string|max:2|in:R,A,O',
            'detalleLev.*.linea'=>'required|integer|max_digits:10|exists:gesconfiguracionlineas,linea',
            'detalleLev.*.estacaIni'=>'required|numeric|max_digits:7|exists:gesestacas,estaca',
            'detalleLev.*.estacaInim'=>'required_if:detalleLev.*.tipoLinea,O|numeric|max_digits:7|exclude_if:detalleLev.*.tipoLinea,A',
            'detalleLev.*.estacaFin'=>'required_if:detalleLev.*.tipoLinea,R|numeric|max_digits:7|exists:gesestacas,estaca|gt:detalleLev.*.estacaIni|exclude_unless:detalleLev.*.tipoLinea,R',
            'detalleLev.*.estacaFinm'=>'nullable|numeric|max_digits:7|min:1|exclude_unless:detalleLev.*.tipoLinea,R',
            'detalleLev.*.cultivo'=>'required|integer|max_digits:7|exists:gescultivostab,idCultivo',
        ];
        $messages= [
            //customMessages
            //'proyecto.required' => 'El campo :attribute es requerido',
            'detalleLev.*.linea.required'=>'la linea #:index es requerida'
        ];
        $attributes=[
            //custom attributes
            'idPermiso'=>'idPermiso',//se coloco para no separar el campo a= id permiso
            //'detalleLev.*.tipoLinea' => 'tipo de línea en el detalle :position',
            //'detalleLev.*.tipoLinea' => 'tipo de línea en el detalle :index',
            //'detalleLev.*.tipoLinea' => 'tipo de línea en el detalle :position',
            'detalleLev' => 'detalleLev',
            'detalleLev.*.tipoLinea' => 'tipo de línea en el detalle',
            'detalleLev.*.linea' => 'línea en el detalle',
            'detalleLev.*.estacaIni' => 'estacaIni',
            'detalleLev.*.estacaInim' => 'estacaInim',
        ];
        $validator = Validator::make($request->all(), $rules, $messages,$attributes);
        //$request->validate($rules,$messages,$attributes);
        //*agrupar los errores por cada elemento del arreglo 
        if ($validator->fails()) { 
            $errors = []; 
            foreach ($validator->errors()->getMessages() as $field => $messages) { 
                if (preg_match('/detalleLev\.(\d+)\./', $field, $matches)) { 
                    $index = $matches[1]; 
                    if (!isset($errors["detalleLev.$index"])) { 
                    //if (!isset($errors['detalleLev'][$index])) {
                        $errors["detalleLev.$index"] = []; 
                    } 
                    foreach ($messages as $message) { 
                        $errors["detalleLev.$index"][] = $message; 
                    } 
                }
                else { 
                    $errors[$field] = $messages; 
                } 
            } 
            return response()->json(['errors' => $errors], 422); 
        }
        
        return  response()->json(["status"=>'todo ok','data'=>$validator->validated()],200);

    }
    
    public function permiso(){
        $permisos=Levantamiento::with('permiso:IdPermiso,fechaPermiso,numPermiso')->get(['IdLevantamiento','fechaLevantamiento','numFiniquito','IdPermiso']);
        return $permisos;
    }
}
