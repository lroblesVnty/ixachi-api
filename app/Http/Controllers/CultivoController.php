<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cultivo;
use Illuminate\Http\Request;

class CultivoController extends Controller{
    
    public function index(){
        //$cultivos=Cultivo::all(['idCultivo','cultivo']);
        $cultivos= Cultivo::select(['idCultivo','cultivo','zona'])
        ->distinct('cultivo')
        ->where('precioHectarea', '>',0)
        ->where('zona', '=','VERACRUZ')
        ->get();
        return $cultivos;
    }
}
