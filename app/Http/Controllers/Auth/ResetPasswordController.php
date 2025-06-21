<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;
use App\Models\UsuarioPasswordHistory;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /**
     * Mostrar el formulario para poner la nueva contraseña.
     */
    public function showResetForm($token)
    {
        $correo_electronico = request('correo_electronico');
        return view('auth.passwords.reset', compact('token', 'correo_electronico'));
    }

    /**
     * Guardar la nueva contraseña.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'correo_electronico' => 'required|email|exists:usuarios,correo_electronico',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        $reset = DB::table('password_resets')
            ->where('email', $request->correo_electronico)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->withErrors(['correo_electronico' => 'El token es inválido o ha expirado.']);
        }

        $usuario = Usuario::where('correo_electronico', $request->correo_electronico)->first();
        if (!$usuario) {
            return back()->withErrors(['correo_electronico' => 'No se encontró el usuario.']);
        }

        // Validar que la nueva contraseña no sea igual a las últimas 3
        $lastPasswords = $usuario->passwordHistories()->latest()->take(3)->pluck('password');
        foreach ($lastPasswords as $oldHash) {
            if (Hash::check($request->password, $oldHash)) {
                return back()->withErrors(['password' => 'No puedes reutilizar tus últimas 3 contraseñas.']);
            }
        }

        $usuario->contrasena = Hash::make($request->password);
        $usuario->save();

        // Guardar la nueva contraseña en el historial
        UsuarioPasswordHistory::create([
            'usuario_id' => $usuario->id_usuario,
            'password' => $usuario->contrasena,
        ]);

        // Eliminar el registro de password_resets
        DB::table('password_resets')->where('email', $request->correo_electronico)->delete();

        return redirect()->route('login')->with('status', '¡Tu contraseña ha sido restablecida!');
    }

    /**
     * Alias para reset, útil para pruebas o rutas alternativas.
     */
    public function resetPassword(Request $request)
    {
        return $this->reset($request);
    }
}
