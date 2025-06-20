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

        // 3) Recuperar el rol elegido, y luego limpiar la sesión
        $rol = session('rol', 'empleado');
        session()->forget('rol');

        // 4) Crear o actualizar usuario, asignando el rol que recogimos
        $user = Usuario::where('google_id', $googleUser->getId())
            ->orWhere('correo_electronico', $googleUser->getEmail())
            ->first();

        if ($user) {
            $user->update([
                'google_id'     => $googleUser->getId(),
                'google_token'  => $googleUser->token,
                'foto_perfil'   => $googleUser->getAvatar(),
                'rol'           => $rol,            // <— Actualizar rol
            ]);
        } else {
            $user = Usuario::create([
                'nombre_usuario'     => $googleUser->getName() ?? Str::before($googleUser->getEmail(), '@'),
                'correo_electronico' => $googleUser->getEmail(),
                'contrasena'         => bcrypt(Str::random(16)),
                'rol'                => $rol,        // <— Usar el rol de sesión
                'activo'             => false,
                'token_activacion'   => Str::random(60),
                'google_id'          => $googleUser->getId(),
                'google_token'       => $googleUser->token,
                'foto_perfil'        => $googleUser->getAvatar(),
            ]);
        }

        Auth::login($user, true);

        // 5) Redirección según rol
        if ($user->rol === 'admin') {
            return redirect()->intended('/admin/dashboard');
        } elseif ($user->rol === 'empleado') {
            return redirect()->intended('/empleado/dashboard');
        } elseif ($user->rol === 'empleador') {
            return redirect()->intended('/empleador/dashboard');
        }

        return redirect()->intended('/');
    }
}
