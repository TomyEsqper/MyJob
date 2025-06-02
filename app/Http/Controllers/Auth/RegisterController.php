<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;

class RegisterController extends Controller
{
    /**
     * A dónde redirigir tras el registro.
     */
    protected string $redirectTo = '/empleador/dashboard';

    public function __construct()
    {
        // Middleware disponible porque extendemos App\Http\Controllers\Controller
        $this->middleware('guest');
    }

    /**
     * Muestra el formulario de registro.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Procesa el registro y devuelve JSON.
     */
    public function register(Request $request): JsonResponse
    {
        // Valida y lanza excepción automáticamente si falla
        $this->validator($request->all())->validate();

        // Crea el usuario
        $user = $this->create($request->all());

        // Retorna JSON y código 201
        return response()->json([
            'message' => 'Registro exitoso',
            'user'    => [
                'id'    => $user->id_usuario,
                'name'  => $user->nombre_usuario,
                'email' => $user->correo_electronico,
                'rol'   => $user->rol,
            ],
        ], 201);
    }

    /**
     * Validador de los datos de registro.
     *
     * @param  array  $data
     * @return ValidatorContract
     */
    protected function validator(array $data): ValidatorContract
    {
        return Validator::make($data, [
            'name'               => ['required', 'string', 'max:255'],
            'correo_electronico' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,correo_electronico'],
            'password'           => ['required', 'string', 'min:8', 'confirmed'],
            'nit'                => ['nullable', 'string'],
        ]);
    }

    /**
     * Crea una nueva instancia de usuario.
     *
     * @param  array  $data
     * @return Usuario
     */
    protected function create(array $data): Usuario
    {
        $rol = str_ends_with(strtolower($data['correo_electronico']), '@myjob.com')
            ? 'admin'
            : 'empleado';

        return Usuario::create([
            'nombre_usuario'     => $data['name'],
            'correo_electronico' => $data['correo_electronico'],
            'contrasena'         => Hash::make($data['password']),
            'rol'                => $rol,
            'nit'                => $data['nit'] ?? null,
        ]);
    }
}
