<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oferta;
use Illuminate\Support\Facades\Auth;
use App\Traits\UploadTrait;
use App\Models\Usuario;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use App\Models\Aplicacion;
use App\Models\VistaPerfil;
use App\Models\Notificacion;

class EmpleadoController extends Controller
{
    use UploadTrait;

    public function dashboard()
    {
        $usuario = Auth::user();
        
        // Get statistics
        $aplicacionesEnviadas = $usuario->aplicaciones()->count();
        $vistasPerfilCount = VistaPerfil::where('empleado_id', $usuario->id_usuario)->count();
        $entrevistasCount = $usuario->aplicaciones()->where('estado', 'aceptada')->count();
        
        // Get recent applications
        $aplicacionesRecientes = $usuario->aplicaciones()
            ->with(['oferta.empleador'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get available job offers
        $ofertas = Oferta::with(['empleador.empleador'])
            ->where('estado', 'activa')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('empleado.dashboard', compact(
            'aplicacionesEnviadas',
            'vistasPerfilCount',
            'entrevistasCount',
            'aplicacionesRecientes',
            'ofertas'
        ));
    }

    public function perfil(Request $request, $id = null)
    {
        $usuario = $id ? Usuario::findOrFail($id) : Auth::user();
        // Si el usuario autenticado está viendo el perfil de otro usuario, registrar la vista
        if ($id && Auth::id() !== (int)$id) {
            VistaPerfil::create([
                'empleado_id' => $id,
                'visitante_id' => Auth::id(),
                'user_agent' => $request->header('User-Agent'),
                'ip' => $request->ip(),
            ]);
        }
        return view('empleado.perfil', ['empleado' => $usuario]);
    }

    public function actualizarPerfil(Request $request, $id)
    {
        $request->validate([
            'nombre_usuario' => 'required|string|max:255',
            'profesion' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'experiencia' => 'nullable|string',
            'educacion' => 'nullable|string',
            'telefono' => 'nullable|string|max:20',
            'ubicacion' => 'nullable|string|max:255',
            'habilidades' => 'nullable|string',
            'whatsapp' => 'nullable|string|max:30',
            'facebook' => 'nullable|string|max:100',
            'instagram' => 'nullable|string|max:100',
            'linkedin' => 'nullable|string|max:100',
            'resumen_profesional' => 'nullable|string|max:1000',
            'disponibilidad_horario' => 'nullable|string|max:100',
            'disponibilidad_jornada' => 'nullable|string|max:100',
            'disponibilidad_movilidad' => 'nullable|boolean',
        ], [
            'nombre_usuario.required' => 'El nombre es obligatorio.',
            'profesion.required' => 'La profesión es obligatoria.',
            'whatsapp.max' => 'El WhatsApp no puede superar 30 caracteres.',
            'facebook.max' => 'El Facebook no puede superar 100 caracteres.',
            'instagram.max' => 'El Instagram no puede superar 100 caracteres.',
            'linkedin.max' => 'El LinkedIn no puede superar 100 caracteres.',
            'resumen_profesional.max' => 'El resumen profesional no puede superar 1000 caracteres.',
        ]);

        $usuario = Usuario::findOrFail($id);
        $usuario->nombre_usuario = $request->nombre_usuario;
        $usuario->profesion = $request->profesion;
        $usuario->descripcion = $request->descripcion;
        $usuario->experiencia = $request->experiencia;
        $usuario->educacion = $request->educacion;
        $usuario->telefono = $request->telefono;
        $usuario->ubicacion = $request->ubicacion;
        $usuario->habilidades = $request->habilidades;
        $usuario->whatsapp = $request->whatsapp;
        $usuario->facebook = $request->facebook;
        $usuario->instagram = $request->instagram;
        $usuario->linkedin = $request->linkedin;
        $usuario->resumen_profesional = $request->resumen_profesional;
        $usuario->disponibilidad_horario = $request->disponibilidad_horario;
        $usuario->disponibilidad_jornada = $request->disponibilidad_jornada;
        $usuario->disponibilidad_movilidad = $request->has('disponibilidad_movilidad') ? (bool)$request->disponibilidad_movilidad : null;
        $usuario->save();

        return redirect()->back()->with('success', 'Perfil actualizado correctamente');
    }

    public function actualizarFoto(Request $request)
    {
        $request->validate([
            'foto_perfil' => 'required|image|mimes:jpeg,png,jpg|max:5120', // 5MB
        ]);

        $user = Auth::user();

        // Eliminar foto anterior si existe y no es una URL de Google
        if ($user->foto_perfil && !filter_var($user->foto_perfil, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($user->foto_perfil);
        }

        // Guardar la nueva foto
        $path = $request->file('foto_perfil')->store('fotos_perfil', 'public');

        // Actualizar la ruta en la base de datos
        $user->foto_perfil = $path;
        $user->save();

        return redirect()->back()->with('success', 'Tu foto de perfil ha sido actualizada.');
    }

    public function actualizarHabilidades(Request $request)
    {
        $request->validate([
            'habilidades' => 'required|array',
            'habilidades.*' => 'required|string|max:255'
        ]);

        $usuario = Auth::user();
        $usuario->habilidades = implode(',', $request->habilidades);
        $usuario->save();

        return response()->json(['success' => true, 'message' => 'Habilidades actualizadas correctamente']);
    }

    public function actualizarCV(Request $request)
    {
        $request->validate([
            'cv' => 'required|mimes:pdf,doc,docx|max:10240'
        ]);

        $usuario = Auth::user();

        if ($request->hasFile('cv')) {
            // Eliminar CV anterior si existe
            if ($usuario->cv_path) {
                Storage::delete('public/cvs/' . basename($usuario->cv_path));
            }

            // Guardar nuevo CV
            $path = $request->file('cv')->store('public/cvs');
            $usuario->cv_path = Storage::url($path);
            $usuario->save();
        }

        return redirect()->back()->with('success', 'CV actualizado correctamente');
    }

    public function aplicar(Oferta $oferta)
    {
        $usuario = Auth::user();
        
        // Verificar si el usuario ya aplicó a esta oferta
        if ($usuario->aplicaciones()->where('oferta_id', $oferta->id)->exists()) {
            return redirect()->back()->with('error', 'Ya has aplicado a esta oferta anteriormente.');
        }

        // Crear la aplicación
        $usuario->aplicaciones()->create([
            'oferta_id' => $oferta->id,
            'estado' => 'pendiente'
        ]);

        return redirect()->back()->with('success', 'Has aplicado exitosamente a la oferta.');
    }

    public function verOferta(Oferta $oferta)
    {
        // Cargar las relaciones necesarias
        $oferta->load([
            'empleador.empleador', // Cargar el usuario empleador y sus datos de empleador
            'aplicaciones' => function ($query) {
                $query->where('empleado_id', Auth::id());
            }
        ]);

        return view('empleado.ofertas.show', compact('oferta'));
    }

    public function aplicaciones(Request $request)
    {
        $usuario = Auth::user();
        
        $query = $usuario->aplicaciones()
            ->with(['oferta.empleador'])
            ->orderBy('created_at', 'desc');
            
        // Filtrar por estado si se especifica
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        
        // Obtener las aplicaciones paginadas
        $aplicaciones = $query->paginate(10);
        
        return view('empleado.aplicaciones', compact('aplicaciones'));
    }

    public function buscar(Request $request)
    {
        $query = Oferta::with(['empleador.empleador'])
            ->where('estado', 'activa');

        if ($request->filled('titulo')) {
            $query->where('titulo', 'like', '%' . $request->titulo . '%');
        }
        if ($request->filled('ubicacion')) {
            $query->where('ubicacion', 'like', '%' . $request->ubicacion . '%');
        }
        if ($request->filled('tipo_contrato')) {
            $query->where('tipo_contrato', $request->tipo_contrato);
        }

        $ofertas = $query->orderBy('created_at', 'desc')->paginate(10);

        // Para mantener los filtros en la paginación
        $ofertas->appends($request->all());

        return view('empleado.ofertas.buscar', [
            'ofertas' => $ofertas,
            'filtros' => $request->only(['titulo', 'ubicacion', 'tipo_contrato'])
        ]);
    }

    public function configuracion()
    {
        return view('empleado.configuracion');
    }

    public function actualizarContrasena(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
        $usuario = Auth::user();
        if (!\Hash::check($request->current_password, $usuario->contrasena)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }
        $usuario->contrasena = bcrypt($request->new_password);
        $usuario->save();
        return back()->with('success', 'Contraseña actualizada correctamente.');
    }

    public function eliminarCuenta(Request $request)
    {
        $usuario = Auth::user();
        Auth::logout();
        $usuario->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Tu cuenta ha sido eliminada.');
    }

    public function guardarPreferencias(Request $request)
    {
        $request->validate([
            'notificaciones_email' => 'required',
            'idioma' => 'required',
            'tema' => 'required',
        ]);
        $usuario = Auth::user();
        $usuario->update($request->only(['notificaciones_email', 'idioma', 'tema']));
        return back()->with('success', 'Preferencias actualizadas correctamente.');
    }

    public function actualizarCorreo(Request $request)
    {
        $request->validate([
            'correo_electronico' => 'required|email|unique:usuarios,correo_electronico,' . Auth::id() . ',id_usuario',
        ]);
        $usuario = Auth::user();
        $usuario->correo_electronico = $request->correo_electronico;
        $usuario->save();
        return back()->with('success', 'Correo electrónico actualizado correctamente.');
    }

    public function actualizarPrivacidad(Request $request)
    {
        $request->validate([
            'privacidad_perfil' => 'required',
        ]);
        $usuario = Auth::user();
        $usuario->privacidad_perfil = $request->privacidad_perfil;
        $usuario->save();
        return back()->with('success', 'Privacidad actualizada correctamente.');
    }

    public function cerrarOtrasSesiones(Request $request)
    {
        $user = Auth::user();
        Auth::logoutOtherDevices($request->current_password);
        return back()->with('success', 'Otras sesiones cerradas correctamente.');
    }

    public function notificaciones()
    {
        $usuario = Auth::user();
        $notificaciones = Notificacion::where('usuario_id', $usuario->id_usuario)
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get()
            ->map(function($n) {
                return [
                    'tipo' => $n->tipo,
                    'mensaje' => $n->mensaje,
                    'fecha' => $n->created_at->format('d/m/Y H:i'),
                    'leida' => $n->leida,
                ];
            });
        return view('empleado.notificaciones', compact('notificaciones'));
    }

    public function notificacionesAjax()
    {
        $usuario = Auth::user();
        $notificaciones = Notificacion::where('usuario_id', $usuario->id_usuario)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function($n) {
                return [
                    'tipo' => $n->tipo,
                    'mensaje' => $n->mensaje,
                    'fecha' => $n->created_at->format('d/m/Y H:i'),
                    'leida' => $n->leida,
                ];
            });
        return response()->json($notificaciones);
    }

    /**
     * Actualiza un campo individual del perfil por AJAX
     */
    public function actualizarCampo(Request $request)
    {
        $request->validate([
            'campo' => 'required|in:whatsapp,facebook,instagram,linkedin,disponibilidad_horario,disponibilidad_jornada,disponibilidad_movilidad,resumen_profesional',
        ]);
        $usuario = Auth::user();
        $campo = $request->campo;
        $reglas = [
            'whatsapp' => 'nullable|string|max:100',
            'facebook' => 'nullable|string|max:100',
            'instagram' => 'nullable|string|max:100',
            'linkedin' => 'nullable|string|max:100',
            'disponibilidad_horario' => 'nullable|string|max:100',
            'disponibilidad_jornada' => 'nullable|string|max:100',
            'disponibilidad_movilidad' => 'nullable|boolean',
            'resumen_profesional' => 'nullable|string|max:1000',
        ];
        $valorRegla = $reglas[$campo] ?? 'nullable|string|max:255';
        $request->validate([
            'valor' => $valorRegla,
        ]);
        $valor = $campo === 'disponibilidad_movilidad' ? (bool)$request->valor : $request->valor;
        $usuario->$campo = $valor;
        $usuario->save();
        return response()->json(['success' => true, 'campo' => $campo, 'valor' => $usuario->$campo]);
    }

    /**
     * Elimina (limpia) un campo individual del perfil por AJAX
     */
    public function eliminarCampo(Request $request)
    {
        $request->validate([
            'campo' => 'required|in:whatsapp,facebook,instagram,linkedin,disponibilidad_horario,disponibilidad_jornada,disponibilidad_movilidad,resumen_profesional',
        ]);
        $usuario = Auth::user();
        $campo = $request->campo;
        $usuario->$campo = $campo === 'disponibilidad_movilidad' ? null : null;
        $usuario->save();
        return response()->json(['success' => true, 'campo' => $campo, 'valor' => null]);
    }
}
