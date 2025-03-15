<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Levantamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreLevantamientoRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class LevantamientoController extends Controller{

    public function index() {
        
        return Levantamiento::select('IdLevantamiento',DB::raw("DATE_FORMAT(fechaLevantamiento, '%d/%m/%Y') as fechaLevantamiento"),'numFiniquito','nombreStatus as statusPago','IdPermiso')
        ->join('gescatestatuspago', 'geslevantamientos.idStatusPago', '=', 'gescatestatuspago.idStatusPago')//checar si hacer un controlador y modelo para gescatestatuspago
        ->with(['permiso' => function ($query) {
            $query->select('IdPermiso','fechaPermiso','numPermiso','IdPredio');
        }, 'permiso.predio' => function ($query) {
            $query->select('IdPredio', 'IdPropietario','idProyecto')
            ->join('gesconfiguracionlineas', 'gespredios.idLinea', '=', 'gesconfiguracionlineas.linea');
        },'permiso.predio.propietario'=>function($query){
            $query->select('IdPropietario',DB::raw("CONCAT_WS(' ', nombre, apPaterno, apMaterno) AS nombre"));
        }
        ])->get();
    }

    public function show($id){

        return Levantamiento::select('IdLevantamiento',DB::raw("DATE_FORMAT(fechaLevantamiento, '%d/%m/%Y') as fechaLevantamiento"),'numFiniquito','nombreStatus as statusPago','observaciones','IdPermiso')
        ->join('gescatestatuspago', 'geslevantamientos.idStatusPago', '=', 'gescatestatuspago.idStatusPago')//checar si hacer un controlador y modelo para gescatestatuspago
        ->with(['permiso' => function ($query) {
            $query->select('IdPermiso','fechaPermiso','numPermiso','IdPredio');
        }, 'permiso.predio' => function ($query) {
            $query->select('IdPredio', 'IdPropietario','idProyecto')
            ->join('gesconfiguracionlineas', 'gespredios.idLinea', '=', 'gesconfiguracionlineas.linea');
        },'permiso.predio.propietario'=>function($query){
            $query->select('IdPropietario',DB::raw("CONCAT_WS(' ', nombre, apPaterno, apMaterno) AS nombre"));
        }
        ])->where('idLevantamiento', '=', $id)->firstOrFail();
       // ->get();


    }


     /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLevantamientoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLevantamientoRequest $request){

        $rutaFoto='';
        if ($request->hasFile('foto')) {
            if ($request->validated()) {
                $foto = $request->file('foto');
                $dir='fotos/P-'.$request->input('idPermiso');
                $rutaFoto = $foto->store($dir, 'public'); //*se guarda con un nombre generado automaticamente
               //$rutaFoto = $request->photo->storeAs('images', 'filename.jpg', 'public');//*nombre personalizado
               //TODO PERSONALIZAR LA RUTA CON EL NOMBRE DEL PROPIETAARIO Y EL PERMISO
            }
        }       
      //  $validator = Validator::make($request->all(), $rules, $messages,$attributes);
        //*agrupar los errores por cada elemento del arreglo 
       
        //return  response()->json(["status"=>'todo ok','data'=>$validator->validated()],200);
        $requValid=$request->validated();
        //*formas de verificar si existe un campo del request
       // forma1= $valor = $request->input('campo', 'valor por defecto');
        //forma2 if ($request->has('campo')) {
        //TODO mapear los campos del request a los campos de la base de datos
        $detalleData = collect($requValid['detalleLev'])->map(function ($detalle) {
            return [ 'tipoLinea' => $detalle['tipoLinea'], 'linea' => $detalle['linea'],
            'estacaIni'=>$detalle['estacaIni'],'mtsIni'=>$detalle['estacaInim']??null,
            'estacaFin'=>$detalle['estacaFin']??null,'mtsFin'=>(isset($detalle['estacaFinm']))?$detalle['estacaFinm']:null,
            'metros'=>$detalle['metros'],'metros2'=>$detalle['metros2'],'km'=>$detalle['km'],
            'ha'=>$detalle['ha'],'idCultivo'=>$detalle['cultivo'] 
            ];
         })->toArray();

         // Crear múltiples posts $posts = [ ['title' => 'Segundo Post', 'content' => 'Contenido del segundo post.'], ['title' => 'Tercer Post', 'content' => 'Contenido del tercer post.'], ]; // Guardar los posts a través de la relación del usuario $user->posts()->createMany($posts);
         $fechaLev = Carbon::createFromFormat('d/m/Y', $requValid['fechaLev'])->format('Y-m-d');
        $levantamiento = Levantamiento::create([ 
            'fechaLevantamiento' => $fechaLev, 'observaciones' => $requValid['observaciones']??null, 
            'idPermiso' => $requValid['idPermiso'],'idPersonal'=>57, 
            'imgUrl' => $rutaFoto,'numFiniquito'=>$requValid['finiquito'], 
        ]);
       // $detalle = $levantamiento->detalles()->create($detalleData);
        $levantamiento->detalles()->createMany($detalleData);
        /*$detalle = $levantamiento->detalle()->create([
            'tipoLinea' => 'Otro Post', 'content' => 'Más contenido del post.',
        ]);*/

       //return  response()->json(["status"=>'todo ok',"data"=>$request->validated(),'postData'=>$detalleData],200);
        return  response()->json(["status"=>'todo ok','data'=>$levantamiento,'detalle'=>''],201);

    }
    
    public function permiso(){
        $permisos=Levantamiento::with('permiso:IdPermiso,fechaPermiso,numPermiso')->get(['IdLevantamiento','fechaLevantamiento','numFiniquito','IdPermiso']);
        return $permisos;
    }
}
