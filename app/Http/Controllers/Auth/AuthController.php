<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
//use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller{
    
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

        //TODO checar como funcionan las cookies 
        //
        
        return response()->json([
            'status'=>true,
            'message'=>'Sesion iniciada correctamente',
            'data'=>$user,
            'access_token'=>$user->createToken('auth-token')->plainTextToken

        ]);


        
    }
}
