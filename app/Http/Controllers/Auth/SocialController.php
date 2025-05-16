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

        $user = Usuario::updateOrCreate(
            ['correo_electronico' => $googleUser->getEmail()],
            [
                'nombre_usuario' => $googleUser->getName() ?? Str::before($googleUser->getEmail(), '@'),
                'contrasena' => bcrypt(Str::random(16)),
                'rol' => str_ends_with(strtolower($googleUser->getEmail()), '@myjob.com') ? 'admin' : 'empleado',
                'activo' => false,
                'token_activacion' => Str::random(60),
                'google_id' => $googleUser->getId(),
                'google_token' => $googleUser->token,
                'foto_perfil' => $googleUser->getAvatar(),
            ]
        );

        Auth::login($user, true);

        return redirect()->intended('/empleado/dashboard');
    }
}
