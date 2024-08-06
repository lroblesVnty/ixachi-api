<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Propietario;
use Illuminate\Http\Request;

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
}
