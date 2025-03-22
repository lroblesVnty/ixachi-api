<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DetalleLevantamiento;
use Illuminate\Http\Request;

class DetalleLevantamientoController extends Controller{
    public function detalleByLev($idLev){
        return DetalleLevantamiento::with('afectacion','tipLinea')
        ->where('idLevantamiento', '=', $idLev)->firstOrFail();
        
    }
}
