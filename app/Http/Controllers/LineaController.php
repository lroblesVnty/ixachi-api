<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Estaca;
use App\Models\Linea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LineaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function lineaByProyTipo(Request $request){
        //return $request->all();

        $request->validate(
            [
            'proyecto' => 'required|exists:proyectos,nombreProyecto',
            'tipoLinea' => 'required|in:R,A,O',
            ],
            [//custom messages
                'proyecto.required' => 'El campo :attribute es requerido',
                'tipoLinea.required' => 'El campo :attribute es requerido'
            ]
        );

        $proy = $request->query('proyecto');
        $tipo = $request->query('tipoLinea');
        $tlinea = ($tipo == 'R') ? "estaca" : "pt";
        $lineas=Linea::select(['linea'])
        ->where('idProyecto', '=', $proy)
        ->get();

        return Estaca::select(['linea'])
        ->distinct()
        ->where('tipo', '=', $tlinea)
        ->whereIn('linea',$lineas)
        ->get();
        DB::table('gesestacas')
        ->select('linea')
        ->distinct()
        ->where('tipo', '=', $tlinea)
        ->whereIn('linea',$lineas)
        ->get();
    }

    public function distanciaByLinea (Request $request,$linea){
        $request->merge(['linea' => $request->route('linea')]);
        $request->validate(
            [
            'linea' => 'required|exists:gesconfiguracionlineas,linea'
            ]
        );

        $distancia=Linea::select(['distancia'])
        ->where('linea', '=', $linea)
        ->get();
      response()->json(["distancia"=>$distancia],401);

       return Linea::where('linea', $linea)
               ->first(['distancia']);
        

    }
}
