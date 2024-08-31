<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectoController extends Controller{
    public function index(){
        $proyectos=Proyecto::all();
        return $proyectos;
    }

    public function proybyDept(){
        $proyectos=Proyecto::where('departamento','GES')->get();
        return $proyectos;
    }


}
