<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::get();
        return response()->json($usuarios, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6"
        ]);

        try {
            DB::beginTransaction();

            // Código para crear el usuario
            $usuario = new User();
            $usuario->name = $request->name;
            $usuario->email = $request->email;
            $usuario->password = bcrypt($request->password);
            $usuario->save();

            DB::commit();

            return response()->json(["mensaje" => "Usuario creado correctamente! :)"], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Error al crear el usuario: " . $e->getMessage()], 502);
            //return response()->json(["mensaje" => "Error al crear el usuario: " . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $usuario = User::findOrFail($id);
        return response()->json($usuario, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email,$id",
        ]);

        DB::beginTransaction();
        try {
            // Buscamos y modificamos
            $usuario = User::findOrFail($id);
            $usuario->name = $request->name;
            $usuario->email = $request->email;
            if(isset($request->password) && !empty($request->password)){
                $usuario->password = Hash::make($request->password);
            }
            $usuario->update();

            DB::commit();

            return response()->json(["mensaje" => "Usuario actualizado correctamente! :)"], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Error al actualizar el usuario: " . $e->getMessage()], 502);
        }

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = User::findorFail($id);
        //$usuario->delete();

        return response()->json(["mensaje" => "Usuario eliminado correctamente! :)"], 200);
    }
}
