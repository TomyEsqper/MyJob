<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Empleador;
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
        // Validación de los campos del formulario
        $validator = Validator::make($request->all(), [
            // Solo requerido si es empleado
            'name' => 'required_if:rol,empleado|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios,correo_electronico',
            'password' => 'required|string|min:8|confirmed',
            'rol' => 'required|in:empleado,empleador',
            // Validación para el registro de empresa
            'nit' => 'required_if:rol,empleador|string|max:255|unique:empleadores,nit',
            'nombre_empresa' => 'required_if:rol,empleador|string|max:255|unique:empleadores,nombre_empresa',
            'correo_empresarial' => 'required_if:rol,empleador|email|max:255|unique:empleadores,correo_empresarial',
            'direccion_empresa' => 'required_if:rol,empleador|string',
            'telefono_contacto' => 'required_if:rol,empleador|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        $rol = str_ends_with(strtolower($request->email), '@myjob.com') ? 'admin' : $request->rol;

        // Crear el usuario
        $usuario = Usuario::create([
            'nombre_usuario' => $rol === 'empleador' ? $request->nombre_empresa : $request->name,
            'correo_electronico' => $request->email,
            'contrasena' => Hash::make($request->password),
            'rol' => $rol
        ]);

        // Si el rol es "empleador", entonces los datos de la empresa deben ir a la tabla "empleadores"
        if ($rol === 'empleador') {
            Empleador::create([
                'usuario_id' => $usuario->id_usuario,
                'nit' => $request->nit,
                'correo_empresarial' => $request->correo_empresarial ?? $request->email,
                'nombre_empresa' => $request->nombre_empresa,
                'direccion_empresa' => $request->direccion_empresa,
                'telefono_contacto' => $request->telefono_contacto,
                // Opcionales
                'sitio_web' => $request->sitio_web,
                'sector' => $request->sector,
                'ubicacion' => $request->ubicacion,
                'descripcion' => $request->descripcion,
            ]);
        }

        return response()->json([
            'message' => 'Registro exitoso',
            'user' => [
                'id' => $usuario->id_usuario,
                'name' => $usuario->nombre_usuario,
                'email' => $usuario->correo_electronico,
                'rol' => $usuario->rol
            ],
        ], 201);
    }



    public function checkNit(Request $request)
    {
        $request->validate([
            'nit' => ['required', 'string'],
        ]);

        $empleador = Empleador::where('nit', $request->nit)->first();

        return response()->json([
            'exists' => (bool) $empleador,
            'empresa' => $empleador ? $empleador->nombre_empresa : null,
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Usuario
     */
    protected function create(array $data)
    {
        // Primero creamos el usuario
        $usuario = Usuario::create([
            'nombre_usuario' => $data['nombre_usuario'],
            'correo_electronico' => $data['correo_electronico'],
            'contrasena' => Hash::make($data['password']),
            'rol' => 'empleador',
            'activo' => true
        ]);

        // Si es un empleador, creamos sus datos específicos
        if ($usuario->esEmpleador()) {
            $empleador = Empleador::create([
                'usuario_id' => $usuario->id_usuario,
                'nit' => $data['nit'],
                'correo_empresarial' => $data['correo_empresarial'],
                'nombre_empresa' => $data['nombre_empresa'],
                'direccion_empresa' => $data['direccion_empresa'],
                'telefono_contacto' => $data['telefono_contacto'],
                'sitio_web' => $data['sitio_web'] ?? null,
            ]);
        }

        return $usuario;
    }
}
