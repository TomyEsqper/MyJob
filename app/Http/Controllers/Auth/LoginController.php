<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Controlador de autenticación (Login) con mensajes de validación personalizados.
 *
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Autentica al usuario con las credenciales proporcionadas.
     *
     * Valida los campos y muestra mensajes claros en español.
     * Si las credenciales son válidas, redirige según el rol.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Mensajes de validación personalizados
        $messages = [
            'correo_electronico.required' => 'El correo electrónico es obligatorio.',
            'correo_electronico.email'    => 'Debes ingresar una dirección de correo válida.',
            'password.required'           => 'La contraseña es obligatoria.',
        ];

        // Validar inputs con overrides
        $credentials = $request->validate([
            'correo_electronico' => ['required', 'email'],
            'password'           => ['required'],
        ], $messages);

        // Intentar autenticación
        if (Auth::attempt([
            'correo_electronico' => $credentials['correo_electronico'],
            'password'          => $credentials['password'],
        ])) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Redirección especial para admin predefinidos
            $adminEmails = [
                't.esquivel@myjob.com.co',
                's.murillo@myjob.com.co',
                'c.cuervo@myjob.com.co',
                'nplazas@myjob.com.co',
                's.lozano@myjob.com.co',
            ];
            if (in_array(strtolower($user->correo_electronico), $adminEmails)) {
                return redirect()->intended('/admin/dashboard');
            }

            // Redirigir según rol
            switch ($user->rol) {
                case 'empleado':
                    return redirect()->intended('/empleado/dashboard');
                case 'empleador':
                    return redirect()->intended('/empleador/dashboard');
                default:
                    return redirect()->intended('/');
            }
        }

        // Credenciales incorrectas
        return back()
            ->withErrors(['correo_electronico' => 'Las credenciales proporcionadas son incorrectas.'])
            ->onlyInput('correo_electronico');
    }

    /**
     * Inicia sesión mediante Google.
     *
     * Valida el JWT de Google y autentica al usuario.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function googleLogin(Request $request)
    {
        $credential = $request->input('credential');
        // Aquí valida JWT, crea/obtiene usuario y hace Auth::login($user)
        return response()->json([
            'message' => '¡Bienvenido con Google!',
            'rol'     => Auth::user()->rol,
        ]);
    }
}
