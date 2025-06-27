<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;                    // <— Añadir
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function redirectToGoogle(Request $request)
    {
        // 1) Validar y guardar el rol en sesión
        $allowed = ['empleado','empleador'];
        $rol = $request->get('rol', 'empleado');
        session(['rol' => in_array($rol, $allowed) ? $rol : 'empleado']);

        // 2) Redirigir a Google
        return Socialite::driver('google')
            ->scopes(['openid','profile','email'])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Verificar si el usuario ya existe
        $user = Usuario::where('correo_electronico', $googleUser->getEmail())->first();

        if ($user) {
            // El usuario ya existe, así que lo autenticamos
            $user->update([
                'google_id' => $googleUser->getId(),
                'google_token' => $googleUser->token,
            ]);
            Auth::login($user, true);
        } else {
            // El usuario no existe, es un nuevo registro
            $rol = session('rol', 'empleado');
            session()->forget('rol');

            $user = Usuario::create([
                'nombre_usuario'     => $googleUser->getName() ?? Str::before($googleUser->getEmail(), '@'),
                'correo_electronico' => $googleUser->getEmail(),
                'contrasena'         => bcrypt(Str::random(16)),
                'rol'                => $rol,
                'activo'             => true,
                'google_id'          => $googleUser->getId(),
                'google_token'       => $googleUser->token,
                'foto_perfil'        => $googleUser->getAvatar(),
            ]);
            
            Auth::login($user, true);
        }

        // Redirección unificada según el rol del usuario
        if ($user->rol === 'empleado') {
            return redirect()->intended('/empleado/dashboard');
        } elseif ($user->rol === 'empleador') {
            return redirect()->intended('/empleador/dashboard');
        }

        return redirect()->intended('/');
    }
}
