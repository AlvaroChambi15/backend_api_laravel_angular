<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function funLogin(Request $request){
        // validar
        $credenciales = $request->validate([
            "email" => "required|string|email|max:255",
            "password" => "required|string|min:6",
        ]);
        // autenticar
        if(!Auth::attempt($credenciales)){
            return response()->json(["mensaje" => "Credenciales inválidas!"], 401);
        }
        // generar token
        $token = $request->user()->createToken("Token_Authh")->plainTextToken;
        // responder
        return response()->json([
            "access_token" => $token,
            "usuario" => $request->user(),
            "mensaje" => "Login exitoso!",
        ], 200);

    }

    public function funRegister(Request $request){
        // validar
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users",
            //"password" => "required|string|min:6|confirmed",
            "password" => "required|string|min:6|same:c_password",
        ]);
        // crear usuario
        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        //$usuario->password = bcrypt($request->password);
        $usuario->password = Hash::make($request->password);
        $usuario->save();
        // generar respuesta
        return response()->json(["mensaje" => "Usuario registrado correctamente"], 201);
    }

    public function funProfile(Request $request){
        // responder
        return response()->json($request->user(), 200);
    }

    public function funLogout(Request $request){
        $request->user()->tokens()->delete();
        // responder
        return response()->json(["mensaje" => "LOGOUT exitoso!"], 200);
    }
}
