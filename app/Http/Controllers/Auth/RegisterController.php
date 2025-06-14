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
    /**
     * Muestra el formulario de registro.
     *
     * Este método devuelve la vista del formulario de registro donde los usuarios pueden
     * registrarse como empleados o empleadores.
     *
     * @return \Illuminate\View\View
     */
    public function showForm(){
        return view('auth.register');
    }

    /**
     * Registra a un nuevo usuario.
     *
     * Este método recibe la solicitud de registro y valida los datos del formulario.
     * Si el rol es "empleador", se crea un registro en la tabla `empleadores`.
     * Si el rol es "empleado", se asigna un registro a la tabla `usuarios` con los datos proporcionados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
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
            // Si la validación falla, devuelve el primer error
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        // Determina el rol del usuario (admin, empleado, empleador)
        $rol = str_ends_with(strtolower($request->email), '@myjob.com') ? 'admin' : $request->rol;

        // Crear el usuario con los datos proporcionados
        $usuario = Usuario::create([
            'nombre_usuario' => $rol === 'empleador' ? $request->nombre_empresa : $request->name,
            'correo_electronico' => $request->email,
            'contrasena' => Hash::make($request->password),
            'rol' => $rol
        ]);

        // Si el rol es "empleador", los datos específicos de la empresa se guardan en la tabla "empleadores"
        if ($rol === 'empleador') {
            Empleador::create([
                'usuario_id' => $usuario->id_usuario,
                'nit' => $request->nit,
                'correo_empresarial' => $request->correo_empresarial ?? $request->email,
                'nombre_empresa' => $request->nombre_empresa,
                'direccion_empresa' => $request->direccion_empresa,
                'telefono_contacto' => $request->telefono_contacto,
                'sitio_web' => $request->sitio_web,
                'sector' => $request->sector,
                'ubicacion' => $request->ubicacion,
                'descripcion' => $request->descripcion,
            ]);
        }

        // Responde con un mensaje de éxito y los datos del usuario
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

    /**
     * Verifica si el NIT proporcionado ya está registrado.
     *
     * Este método valida el NIT de una empresa en la base de datos. Si existe un registro con
     * ese NIT, devuelve los detalles de la empresa.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkNit(Request $request)
    {
        // Valida que el NIT sea un valor no vacío y de tipo string
        $request->validate([
            'nit' => ['required', 'string'],
        ]);

        // Busca la empresa asociada al NIT
        $empleador = Empleador::where('nit', $request->nit)->first();

        // Devuelve si el NIT existe o no junto con el nombre de la empresa si existe
        return response()->json([
            'exists' => (bool) $empleador,
            'empresa' => $empleador ? $empleador->nombre_empresa : null,
        ]);
    }

    /**
     * Crea un nuevo usuario después de un registro exitoso.
     *
     * Este método es utilizado cuando un usuario se registra mediante algún sistema
     * (puede ser un formulario o mediante autenticación externa).
     *
     * @param  array  $data
     * @return \App\Models\Usuario
     */
    protected function create(array $data)
    {
        // Crea un nuevo usuario con los datos proporcionados
        $usuario = Usuario::create([
            'nombre_usuario' => $data['nombre_usuario'],
            'correo_electronico' => $data['correo_electronico'],
            'contrasena' => Hash::make($data['password']),
            'rol' => 'empleador',  // Por defecto, asignamos el rol de 'empleador'
            'activo' => true
        ]);

        // Si el usuario es un empleador, crea un registro en la tabla "empleadores"
        if ($usuario->esEmpleador()) {
            Empleador::create([
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
