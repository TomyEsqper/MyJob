<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Models\Usuario;

class ForgotPasswordController extends Controller
{
    /**
     * Mostrar el formulario para solicitar el enlace de reseteo.
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Enviar el enlace de reseteo al correo.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'correo_electronico' => 'required|email|exists:usuarios,correo_electronico',
        ]);

        $usuario = Usuario::where('correo_electronico', $request->correo_electronico)->first();
        if (!$usuario) {
            return back()->withErrors(['correo_electronico' => 'No se encontró un usuario con ese correo.']);
        }

        // Generar el token y guardarlo en la tabla password_resets
        $token = Password::broker('usuarios')->createToken($usuario);

        // Insertar o actualizar el registro en password_resets
        \DB::table('password_resets')->updateOrInsert(
            ['email' => $usuario->correo_electronico],
            [
                'email' => $usuario->correo_electronico,
                'token' => $token,
                'created_at' => now(),
            ]
        );

        // Enviar el correo
        Mail::send('auth.passwords.reset-link', ['token' => $token, 'correo_electronico' => $usuario->correo_electronico], function ($message) use ($usuario) {
            $message->to($usuario->correo_electronico);
            $message->subject('Enlace para restablecer la contraseña');
        });

        return back()->with('status', '¡Te hemos enviado el enlace de restablecimiento a tu correo!');
    }
}
