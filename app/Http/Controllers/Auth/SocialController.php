<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // 1) Busca primero por google_id, si no existe busca por correo
        $user = Usuario::where('google_id', $googleUser->getId())
                     ->orWhere('correo_electronico', $googleUser->getEmail())
                     ->first();

        if ($user){

            // 2a) Si encontró un usuario existente, opcionalmente actualiza su token/avatar
            $user->update([
                'google_id'     => $googleUser->getId(),
                'google_token'  => $googleUser->token,
                'foto_perfil'   => $googleUser->getAvatar(),
            ]);
        } else{

            // 2b) Si no existe, lo crea con todos sus datos
            // Determinar el rol según el dominio o lógica personalizada
            $email = strtolower($googleUser->getEmail());
            if (str_ends_with($email, '@myjob.com')) {
                $rol = 'admin';
            } elseif (str_ends_with($email, '@empresa.com')) {
                $rol = 'empleador';
            } else {
                $rol = 'empleado';
            }
            $user = Usuario::create([
                'nombre_usuario'     => $googleUser->getName()
                                        ?? Str::before($googleUser->getEmail(), '@'),
                'correo_electronico' => $googleUser->getEmail(),
                'contrasena'         => bcrypt(Str::random(16)),
                'rol'                => $rol,
                'activo'             => false,
                'token_activacion'   => Str::random(60),
                'google_id'          => $googleUser->getId(),
                'google_token'       => $googleUser->token,
                'foto_perfil'        => $googleUser->getAvatar(),
            ]);
        }

        // 3) Loguea al usuario (nunca más de una cuenta creada)
        Auth::login($user, true);

        // Redirección dinámica según el rol
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
}

