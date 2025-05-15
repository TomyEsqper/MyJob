<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'correo_electronico' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['email' => $credentials['correo_electronico'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->rol === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->rol === 'empleado') {
                return redirect()->intended('/empleado/dashboard');
            } elseif ($user->rol === 'empleador') {
                return redirect()->intended('/empleador/dashboard');
            }else{
                return redirect()->intended('/');
            }
        }

        return back()->withErrors([
            'correo_electronico' => 'Las credenciales proporcionadas son incorrectas.',
        ])->onlyInput('correo_electronico');
    }

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
