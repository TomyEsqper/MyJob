<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class SocialController extends Controller
{
    /**
     * Redirige al usuario a Google para autenticación.
     */
    public function redirectToGoogle(Request $request)
    {
        try {
            // Validar y guardar el rol en sesión
            $rol = $request->get('rol', 'empleado');
            
            // Asegurar que el rol sea válido
            if (!in_array($rol, ['empleado', 'empleador'])) {
                $rol = 'empleado';
            }
            
            // Guardar el rol en la sesión
            session(['intended_role' => $rol]);
            
            // Redirigir a Google
            return Socialite::driver('google')
                ->scopes(['openid', 'profile', 'email'])
                ->redirect();
                
        } catch (\Exception $e) {
            Log::error('Error al redirigir a Google', [
                'error' => $e->getMessage()
            ]);
            
            return redirect()->route('login')
                ->with('error', 'Hubo un problema al conectar con Google. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Maneja la respuesta de Google.
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            // Obtener el usuario de Google
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            // Obtener el rol guardado en sesión
            $rol = session('intended_role', 'empleado');
            
            // Verificar si el usuario ya existe
            $user = Usuario::where('correo_electronico', $googleUser->getEmail())->first();

            if ($user) {
                // El usuario ya existe
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token,
                    'ultimo_login' => now(),
                ]);
                
                Auth::login($user, true);
                
                Log::info('Usuario existente autenticado', [
                    'email' => $user->correo_electronico
                ]);
            } else {
                // Crear nuevo usuario
                $user = Usuario::create([
                    'nombre_usuario' => $googleUser->getName() ?? Str::before($googleUser->getEmail(), '@'),
                    'correo_electronico' => $googleUser->getEmail(),
                    'contrasena' => Hash::make(Str::random(32)),
                    'rol' => $rol,
                    'activo' => true,
                    'google_id' => $googleUser->getId(),
                    'google_token' => $googleUser->token,
                    'foto_perfil' => $googleUser->getAvatar(),
                    'ultimo_login' => now(),
                ]);
                
                Auth::login($user, true);
                
                Log::info('Nuevo usuario registrado', [
                    'email' => $user->correo_electronico,
                    'rol' => $user->rol
                ]);
            }

            // Limpiar la sesión
            session()->forget('intended_role');

            // Redirección según el rol
            return redirect()->intended($user->rol === 'empleado' ? '/empleado/dashboard' : '/empleador/dashboard')
                ->with('success', '¡Bienvenido a MyJob!');
            
        } catch (\Exception $e) {
            Log::error('Error en autenticación con Google', [
                'error' => $e->getMessage()
            ]);
            
            return redirect()->route('login')
                ->with('error', 'Error al autenticar con Google. Por favor, intenta nuevamente.');
        }
    }
}
