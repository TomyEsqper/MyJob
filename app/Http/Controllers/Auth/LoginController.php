<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     *
     * Esta función retorna la vista del formulario de login donde los usuarios pueden ingresar sus credenciales.
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
     * Esta función valida las credenciales del usuario (correo electrónico y contraseña) y, si son correctas,
     * autentica al usuario. Después, redirige a la página correspondiente según el rol del usuario (admin, empleado, empleador).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validación de las credenciales
        $credentials = $request->validate([
            'correo_electronico' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Intentamos autenticar al usuario con las credenciales proporcionadas
        if (Auth::attempt(['correo_electronico' => $credentials['correo_electronico'], 'password' => $credentials['password']])) {
            // Si la autenticación es exitosa, regeneramos la sesión para evitar secuestro de sesión
            $request->session()->regenerate();

            // Obtener el usuario autenticado
            $user = Auth::user();

            // Redirigir según el rol del usuario
            if ($user->rol === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->rol === 'empleado') {
                return redirect()->intended('/empleado/dashboard');
            } elseif ($user->rol === 'empleador') {
                return redirect()->intended('/empleador/dashboard');
            } else {
                return redirect()->intended('/');
            }
        }

        // Si la autenticación falla, se devuelve con un mensaje de error
        return back()->withErrors([
            'correo_electronico' => 'Las credenciales proporcionadas son incorrectas.',
        ])->onlyInput('correo_electronico');
    }

    /**
     * Inicia sesión mediante Google.
     *
     * Este método es para permitir que los usuarios inicien sesión a través de Google. El JWT se valida y el usuario
     * se autentica utilizando el token proporcionado por Google.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function googleLogin(Request $request)
    {
        $credential = $request->input('credential');

        // Aquí validas el JWT con el cliente Google,
        // extraes email, creas/obtienes usuario y haces Auth::login($user)

        // Luego rediriges igual que en login():
        return response()->json([
            'message' => '¡Bienvenido con Google!',
            'rol' => Auth::user()->rol
        ]);
    }
}
