<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Empleador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Controlador encargado del registro de usuarios y empleadores.
 *
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    /**
     * Muestra el formulario de registro.
     *
     * @return \Illuminate\View\View
     */
    public function showForm()
    {
        return view('auth.register');
    }

    /**
     * Procesa el registro de un nuevo usuario o empleador.
     *
     * Valida los datos de entrada y crea los registros correspondientes en
     * las tablas `usuarios` y `empleadores` según el rol seleccionado.
     *
     * @param  Request  $request  Instancia con los datos del formulario.
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Definición de reglas de validación.
        $rules = [
            'name'               => ['required_if:rol,empleado', 'string', 'min:3', 'max:30'],
            'email'              => 'required|string|email|max:255|unique:usuarios,correo_electronico',
            'password'           => 'required_if:rol,empleado|string|min:8|confirmed',
            'password_empresa'   => 'required_if:rol,empleador|string|min:8|confirmed',
            'rol'                => 'required|in:empleado,empleador',
            'nit'                => 'required_if:rol,empleador|string|max:255|unique:empleadores,nit',
            'nombre_empresa'     => 'required_if:rol,empleador|string|max:255|unique:empleadores,nombre_empresa',
            'correo_empresarial' => 'required_if:rol,empleador|string|email|max:255|unique:empleadores,correo_empresarial',
            'direccion_empresa'  => 'required_if:rol,empleador|string',
            'telefono_contacto'  => 'required_if:rol,empleador|string|max:20',
        ];

        // Mensajes personalizados en español para cada regla.
        $messages = [
            'name.required_if'           => 'El nombre es obligatorio para los empleados.',
            'name.string'                => 'El nombre debe ser un texto.',
            'name.regex'                 => 'El nombre solo puede contener letras, números, espacios, puntos y guiones.',
            'name.min'                   => 'El nombre debe tener al menos 3 caracteres.',
            'name.max'                   => 'El nombre no puede superar los 30 caracteres.',

            'email.required'             => 'El correo electrónico es obligatorio.',
            'email.email'                => 'El correo debe tener un formato válido.',
            'email.unique'               => 'Este correo ya está registrado.',

            'password.required_if'       => 'La contraseña es obligatoria para empleados.',
            'password.min'               => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed'         => 'La confirmación de la contraseña no coincide.',

            'password_empresa.required_if' => 'La contraseña es obligatoria para empleadores.',
            'password_empresa.min'         => 'La contraseña debe tener al menos 8 caracteres.',
            'password_empresa.confirmed'   => 'La confirmación de la contraseña no coincide.',

            'rol.required'               => 'Debe seleccionar un rol.',
            'rol.in'                     => 'El rol seleccionado no es válido.',

            'nit.required_if'            => 'El NIT es obligatorio para empleadores.',
            'nit.string'                 => 'El NIT debe ser texto válido.',
            'nit.max'                    => 'El NIT no puede superar los 255 caracteres.',
            'nit.unique'                 => 'Este NIT ya existe en el sistema.',

            'nombre_empresa.required_if' => 'El nombre de la empresa es obligatorio.',
            'nombre_empresa.string'      => 'El nombre de la empresa debe ser texto.',
            'nombre_empresa.max'         => 'La empresa no puede superar los 255 caracteres.',
            'nombre_empresa.unique'      => 'Esta empresa ya está registrada.',

            'correo_empresarial.required_if' => 'El correo empresarial es obligatorio.',
            'correo_empresarial.email'       => 'El correo empresarial debe ser válido.',
            'correo_empresarial.unique'      => 'Este correo empresarial ya está en uso.',

            'direccion_empresa.required_if'  => 'La dirección de la empresa es obligatoria.',
            'direccion_empresa.string'       => 'La dirección debe ser texto válido.',

            'telefono_contacto.required_if'  => 'El teléfono de contacto es obligatorio.',
            'telefono_contacto.string'       => 'El teléfono debe ser texto válido.',
            'telefono_contacto.max'          => 'El teléfono no puede superar los 20 caracteres.',
        ];

        // Ejecuta la validación.
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si falla, retorna el primer error en formato JSON.
        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorMessage = 'Error en el registro: ';
            
            // Verificar campos específicos según el rol
            if ($request->rol === 'empleado') {
                if ($errors->has('name')) $errorMessage .= 'Nombre requerido. ';
                if ($errors->has('email')) $errorMessage .= 'Email inválido o ya registrado. ';
                if ($errors->has('password')) $errorMessage .= 'Contraseña inválida. ';
            } else {
                if ($errors->has('nit')) $errorMessage .= 'NIT requerido. ';
                if ($errors->has('nombre_empresa')) $errorMessage .= 'Nombre de empresa requerido. ';
                if ($errors->has('correo_empresarial')) $errorMessage .= 'Correo empresarial inválido. ';
                if ($errors->has('direccion_empresa')) $errorMessage .= 'Dirección requerida. ';
                if ($errors->has('telefono_contacto')) $errorMessage .= 'Teléfono requerido. ';
            }
            
            return response()->json([
                'error' => trim($errorMessage)
            ], 422);
        }

        // Determinar qué contraseña usar según el rol
        $password = $request->rol === 'empleador' ? $request->password_empresa : $request->password;

        // Creación del registro en la tabla usuarios.
        $fotoPerfilPath = null;
        if ($request->hasFile('foto_perfil')) {
            $fotoPerfilPath = $request->file('foto_perfil')->store('fotos_perfil', 'public');
        }
        $usuario = Usuario::create([
            'nombre_usuario'     => $request->rol === 'empleador' ? $request->nombre_empresa : $request->name,
            'correo_electronico' => $request->email,
            'contrasena'         => Hash::make($password),
            'rol'                => $request->rol,
            'foto_perfil'        => $fotoPerfilPath,
        ]);

        // Si es empleador, crea registro en empleadores.
        if ($request->rol === 'empleador') {
            Empleador::create([
                'usuario_id'         => $usuario->id_usuario,
                'nit'                => $request->nit,
                'correo_empresarial' => $request->correo_empresarial ?? $request->email,
                'nombre_empresa'     => $request->nombre_empresa,
                'direccion_empresa'  => $request->direccion_empresa,
                'telefono_contacto'  => $request->telefono_contacto,
                // campos opcionales:
                'sitio_web'          => $request->sitio_web,
                'sector'             => $request->sector,
                'ubicacion'          => $request->ubicacion,
                'descripcion'        => $request->descripcion,
            ]);
        }

        // Retorna respuesta exitosa.
        return response()->json([
            'message' => 'Registro exitoso',
            'user' => [
                'id'    => $usuario->id_usuario,
                'name'  => $usuario->nombre_usuario,
                'email' => $usuario->correo_electronico,
                'rol'   => $usuario->rol,
            ],
        ], 201);
    }

    /**
     * Verifica si un NIT ya está registrado en la base de datos.
     *
     * @param  Request  $request  Contiene el NIT a verificar.
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkNit(Request $request)
    {
        // Validación simple del NIT.
        $request->validate([
            'nit' => ['required', 'string'],
        ], [
            'nit.required' => 'El NIT no puede estar vacío.',
            'nit.string'   => 'El NIT debe ser texto válido.',
        ]);

        // Búsqueda de empleador por NIT.
        $empleador = Empleador::where('nit', $request->nit)->first();

        // Devuelve existencia y nombre si corresponde.
        return response()->json([
            'exists'  => (bool) $empleador,
            'empresa' => $empleador ? $empleador->nombre_empresa : null,
        ]);
    }
}
