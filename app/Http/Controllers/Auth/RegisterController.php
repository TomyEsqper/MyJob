<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showForm(){
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_usuario' => 'required|string|max:255',
            'correo_electronico' => 'required|string|email|max:255|unique:usuarios',
            'contrasena' => 'required|string|min:8|confirmed',
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->first()], 400);
        }
        $rol = str_ends_with(strtolower($request->correo_electronico), '@myjob.com') ? 'admin' : 'empleado';
        Usuario::create([
            'nombre_usuario' => $request->nombre_usuario,
            'correo_electronico' => $request->correo_electronico,
            'contrasena' => Hash::make($request->contrasena),
            'rol' => $rol
        ]);

        return response()->json(['message' => 'Registro exitoso']);
    }
}
