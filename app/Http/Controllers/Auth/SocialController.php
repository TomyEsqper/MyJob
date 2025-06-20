<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    /**
     * Redirige al usuario a Google para la autenticación.
     *
     * Este método utiliza Socialite para redirigir al usuario a la página de inicio de sesión de Google.
     * Los permisos solicitados incluyen acceso al perfil y correo electrónico del usuario.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])  // Solicitar permisos de perfil y correo electrónico
            ->redirect();  // Redirige al usuario para que inicie sesión con Google
    }

    /**
     * Maneja la respuesta de Google después de la autenticación.
     *
     * Este método maneja la devolución de datos de Google después de que el usuario se autentique.
     * Si el usuario ya existe en la base de datos, actualiza su información de Google.
     * Si el usuario no existe, lo crea y lo asigna un rol basado en el dominio de su correo electrónico.
     * Luego, el usuario es autenticado en el sistema y redirigido según su rol.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        // Obtiene los datos del usuario de Google usando Socialite
        $googleUser = Socialite::driver('google')->stateless()->user();

        // 1) Busca si ya existe un usuario con el google_id o correo electrónico
        $user = Usuario::where('google_id', $googleUser->getId())
            ->orWhere('correo_electronico', $googleUser->getEmail())
            ->first();

        if ($user){
            // 2a) Si el usuario ya existe, se actualiza el google_id, token y foto de perfil
            $user->update([
                'google_id'     => $googleUser->getId(),
                'google_token'  => $googleUser->token,
                'foto_perfil'   => $googleUser->getAvatar(),
            ]);
        } else {
            // 2b) Si no existe, se crea un nuevo usuario con la información de Google
            // El rol se asigna en función del dominio del correo electrónico
            $email = strtolower($googleUser->getEmail());
            if (str_ends_with($email, '@myjob.com')) {
                $rol = 'admin';  // Si el dominio es "@myjob.com", asigna el rol de admin
            }  else {
                $rol = 'empleado';  // Por defecto, asigna el rol de empleado
            }

            // Crea un nuevo usuario con los datos de Google
            $user = Usuario::create([
                'nombre_usuario'     => $googleUser->getName() ?? Str::before($googleUser->getEmail(), '@'),
                'correo_electronico' => $googleUser->getEmail(),
                'contrasena'         => bcrypt(Str::random(16)),  // Contraseña aleatoria generada para el usuario
                'rol'                => $rol,
                'activo'             => false,  // Inicialmente no activo, esperando confirmación
                'token_activacion'   => Str::random(60),  // Token único para la activación de cuenta
                'google_id'          => $googleUser->getId(),
                'google_token'       => $googleUser->token,
                'foto_perfil'        => $googleUser->getAvatar(),
            ]);
        }

        // 3) Inicia sesión al usuario autenticado
        Auth::login($user, true);

        // Redirige al usuario según su rol
        if ($user->rol === 'admin') {
            return redirect()->intended('/admin/dashboard');  // Redirige a dashboard de admin
        } elseif ($user->rol === 'empleado') {
            return redirect()->intended('/empleado/dashboard');  // Redirige a dashboard de empleado
        } elseif ($user->rol === 'empleador') {
            return redirect()->intended('/empleador/dashboard');  // Redirige a dashboard de empleador
        } else {
            return redirect()->intended('/');  // Redirige al home si el rol no es reconocido
        }
    }
}
