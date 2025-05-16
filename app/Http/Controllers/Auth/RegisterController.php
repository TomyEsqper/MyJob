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
        // 1. Validar según los campos del formulario
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:usuarios',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        // 2. Si falla, devolvemos JSON con código 422
        if($validator->fails()){
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        // 3. Crear el usuario
        $rol = str_ends_with(strtolower($request->email), '@myjob.com')
            ? 'admin'
            : 'empleado';

        $user = Usuario::create([
            'nombre_usuario'        => $request->name,
            'correo_electronico'    => $request->email,
            'contrasena'            => Hash::make($request->password),
            'rol'                   => $rol
        ]);

        // 4. Respuesta JSON de éxito con código 201
        return response()->json([
            'message' => 'Registro exitoso',
            'user' => [
                'id'     => $user->id_usuario,
                'name'   => $user->nombre_usuario,
                'email'  => $user->correo_electronico,
                'rol'    => $user->rol
            ],
        ], 201);
    }
}
