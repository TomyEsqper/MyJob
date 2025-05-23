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
            $user = Usuario::create([
                'nombre_usuario'     => $googleUser->getName()
                                        ?? Str::before($googleUser->getEmail(), '@'),
                'correo_electronico' => $googleUser->getEmail(),
                'contrasena'         => bcrypt(Str::random(16)),
                'rol'                => str_ends_with(
                                            strtolower($googleUser->getEmail()),
                                                '@myjob.com'
                                            ) ? 'admin' : 'empleado',
                'activo'             => false,
                'token_activacion'   => Str::random(60),
                'google_id'          => $googleUser->getId(),
                'google_token'       => $googleUser->token,
                'foto_perfil'        => $googleUser->getAvatar(),
            ]);
        }

        // 3) Loguea al usuario (nunca más de una cuenta creada)
        Auth::login($user, true);

        return redirect()->intended('/empleado/dashboard');
    }
}

