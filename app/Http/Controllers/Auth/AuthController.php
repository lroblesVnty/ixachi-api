<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon; // Asegúrate de importar Carbon
//use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller{

    public function index(Request $request){
        return $request->user();
    }
    
    public function create(Request $request){
        $rules=[
            'name'=>'required|string|max:100',
            'email'=>'required|string|email|max:100|unique:users',
            'password'=>'required|string|min:8',
        ];
        $validator= Validator::make($request->input(),$rules);
        //$validator = Validator::make($request->all(), $rules, $messages,$attributes);
        if($validator->fails()){
            return response()->json(['status'=>false,'errors'=>$validator->errors()->all()],400);
        }
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);
        //$user->assignRole('admin');//asignar un rol al usuario
        //$user->assignRole(['admin', 'editor']);//asignar mass de un role

        return response()->json([
            'status'=>true,
            'message'=>'Usuario creado exitosamente',
            'access_token'=>$user->createToken('auth-token')->plainTextToken

        ],201);
        //return response($user, Response::HTTP_CREATED);
    }

    public function login(Request $request){
        $rules=[
            'email'=>'required|string|email|max:100',
            'password'=>'required|string|min:8'
        ];
        $validator= Validator::make($request->input(),$rules);
        if($validator->fails()){
            return response()->json([
                'status'=>false,'errors'=>$validator->errors()->all()
            ],400);
        }
        if (!Auth::attempt($request->only('email','password'))) {
            return response()->json([
                'status'=>false,'message'=>'Credenciales incorrectas'
            ],401);
        }
       // $user=User::where('email',$request->email)->first();//*obtener ususario aunque no esté autenticado
        $user = Auth::user();//* obtener ususario autenticado
        /** @var \App\Models\User $user */
       // $user->user_roless = $user->getRoleNames()->toArray();//*regresa los roles del usuario

        //$token=$user->createToken('auth-token')->plainTextToken;
        $tokenResult = $user->createToken('auth-token',['*'],Carbon::now()->addMinutes(30));
       

        $tokenPlainText = $tokenResult->plainTextToken; // El token para el cliente
        $expiresAt =$tokenResult->accessToken->expires_at;
        $cookie = cookie('cookie_token', $tokenPlainText, 60 * 24);
       //? $rolesById = $user->getRoleNames()->toArray();
        
        return response()->json([
            'status'=>true,
            'message'=>'Sesion iniciada correctamente',
            'data'=>$user,
            'access_token'=>$tokenPlainText,
            'expires_at' =>$expiresAt ? Carbon::parse($expiresAt)->toDateTimeString() : null,

        ])->withCookie($cookie); 
    }

    public function logout() {
        /** @var \App\Models\User $user */
        auth()->user()->tokens()->delete();
        //Intelephense: Index Workspace//* ejecutar en vscode si marca error en metodo tokens()
       /*  $user = auth()->user();
        $user->tokens()->delete(); */
        //auth()->user()->currentAccessToken()->delete();//*eliminar solo el token actual
        $cookie = Cookie::forget('cookie_token');
        return response()->json([
            'status'=>true,
            'message'=>'Sesion cerrada correctamente'
        ])->withCookie($cookie); 
    }
    
}
