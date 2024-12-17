<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreLevantamientoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array{
        return [
            'fechaLev' => 'required|date_format:d/m/Y',
            'observaciones' => 'nullable|string',
            'idPermiso' => 'required|unique:geslevantamientos,idPermiso|integer|max_digits:5|exists:gespermisos,idPermiso',
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
            'detalleLev.*.metros'=>'numeric|decimal:0,5|min:0',
            'detalleLev.*.metros2'=>'numeric|decimal:0,5|min:0',
            'detalleLev.*.km'=>'numeric|decimal:0,5|min:0',
            'detalleLev.*.ha'=>'numeric|decimal:0,5|min:0|min_digits:1|required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array{
        return [
        //customMessages
            //'proyecto.required' => 'El campo :attribute es requerido',
            'detalleLev.*.linea.required'=>'la linea #:index es requerida'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array{
        return [
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
    }

    protected function failedValidation(Validator $validator){
       /* throw new HttpResponseException(response()->json([
            'erroras' => $validator->errors()->first(),
        ], 572));*/
        //* agrupar los errores por cada elemento del arreglo 
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
           // return response()->json(['errors' => $errors], 422); 
           
           throw new HttpResponseException(response()->json([
            'errors' => $errors], 572));
        }
    }
}
