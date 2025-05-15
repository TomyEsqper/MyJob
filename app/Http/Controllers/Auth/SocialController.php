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
            ->scopes(['openid','profile','email'])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = Usuario::firstOrCreate(
            ['correo_electronico' => $googleUser->getEmail()],
            [
                'nombre_usuario' => $googleUser->getName() ?: Str::before($googleUser->getEmail(), '@'),
                'contrasena'     => bcrypt(Str::random(16)),
                'rol'            => 'empleado',
            ]
        );

        Auth::login($user, true);

        return match($user->rol) {
            'admin'     => redirect()->intended('/admin/dashboard'),
            'empleado'  => redirect()->intended('/empleado/dashboard'),
            'empleador' => redirect()->intended('/empleador/dashboard'),
            default     => redirect()->intended('/'),
        };
    }
}
