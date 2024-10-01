<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Estaca;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstacaController extends Controller{

    public function estacasbylinea(Request $request){
        $request->validate(
            [
            'linea' => 'required|exists:gesconfiguracionlineas,linea|numeric|max_digits:5',
            'tipoLinea' => 'required|in:RECEPTORA,AMPLIACIÓN,OFFSET',
            ]
            /*[//custom messages
                'linea.required' => 'El campo :attribute es requerido',
                'tipoLinea.required' => 'El campo :attribute es requerido'
            ]*/
        );

        $linea = $request->query('linea');
        $tipoLinea = $request->query('tipoLinea');
        if($tipoLinea!='RECEPTORA'){
            return Estaca::select(['estaca'])
            ->where('tipo', '=', 'PT')
            ->where('linea', '=', $linea)
            ->whereNotIn('estaca',function (Builder $query ) use ($linea) {
                $query->select('estacaIni')
                      ->from('gesdetallelevantamientos')
                      ->where('tipoLinea', '=', 'A')
                      ->orWhere('tipoLinea', '=', 'O');
            })
            ->get();
        }
        return Estaca::select(['estaca'])
        ->where('tipo', '=', 'estaca')
        ->where('linea', '=', $linea)
        ->whereNotExists(function (Builder $query ) use ($linea) {
            $query->select('iddetalleLevantamiento')
                  ->from('gesdetallelevantamientos')
                  ->where('tipoLinea', '=', 'R')
                  ->where('linea', '=', $linea)
                  ->whereBetweenColumns('gesestacas.estaca', ['estacaIni', 'estacaFin']);
        })
        ->get();
    }
    
}
