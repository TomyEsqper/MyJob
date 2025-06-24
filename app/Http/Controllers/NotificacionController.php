<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    public function index()
    {
        $notificaciones = Auth::user()
            ->notificaciones()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('empleador.notificaciones.index', compact('notificaciones'));
    }

    public function obtenerNoLeidas()
    {
        $notificaciones = Auth::user()
            ->notificaciones()
            ->where('leida', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'notificaciones' => $notificaciones,
            'count' => $notificaciones->count()
        ]);
    }

    public function marcarComoLeida(Notificacion $notificacion)
    {
        if ($notificacion->usuario_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $notificacion->marcarComoLeida();

        return response()->json(['success' => true]);
    }

    public function marcarTodasComoLeidas()
    {
        Auth::user()
            ->notificaciones()
            ->where('leida', false)
            ->update([
                'leida' => true,
                'leida_en' => now()
            ]);

        return response()->json(['success' => true]);
    }

    public function eliminar(Notificacion $notificacion)
    {
        if ($notificacion->usuario_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $notificacion->delete();

        return response()->json(['success' => true]);
    }

    public function eliminarTodas()
    {
        Auth::user()->notificaciones()->delete();

        return response()->json(['success' => true]);
    }
} 