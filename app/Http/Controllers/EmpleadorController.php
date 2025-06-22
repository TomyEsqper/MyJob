<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Oferta;
use App\Models\Aplicacion;
use App\Models\Usuario;
use App\Models\Empleador;

class EmpleadorController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::user()->id_usuario;
        // Obtener estadísticas del empleador
        $totalOfertas = Oferta::where('empleador_id', $userId)->count();
        $ofertasActivas = Oferta::where('empleador_id', $userId)->where('estado', 'activa')->count();
        $totalAplicaciones = Aplicacion::whereHas('oferta', function($query) use ($userId) {
            $query->where('empleador_id', $userId);
        })->count();
        $totalCandidatos = $totalAplicaciones; // Para compatibilidad con la vista
        $totalContrataciones = Aplicacion::whereHas('oferta', function($query) use ($userId) {
            $query->where('empleador_id', $userId);
        })->where('estado', 'aceptada')->count();
        $totalVistas = 0; // Inicializar en 0, puedes sumar si tienes la columna en el futuro

        // Ofertas recientes
        $ofertasRecientes = Oferta::where('empleador_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Aplicaciones recientes
        $aplicacionesRecientes = Aplicacion::whereHas('oferta', function($query) use ($userId) {
            $query->where('empleador_id', $userId);
        })->with(['empleado', 'oferta'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('empleador.dashboard', compact(
            'totalOfertas',
            'ofertasActivas',
            'totalAplicaciones',
            'totalCandidatos',
            'totalContrataciones',
            'totalVistas',
            'aplicacionesRecientes',
            'ofertasRecientes'
        ));
    }

    public function empresa()
    {
        return view('empleador.empresa');
    }

    public function candidatos(Request $request)
    {
        // Verificar que el usuario sea un empleador
        if (Auth::user()->rol !== 'empleador') {
            abort(403, 'No tienes permiso para ver esta página');
        }

        $userId = Auth::user()->id_usuario;
        // Obtener todas las ofertas del empleador
        $ofertas = Oferta::where('empleador_id', $userId)->get();

        // Si no hay ofertas, mostrar mensaje
        if ($ofertas->isEmpty()) {
            return view('empleador.candidatos.index', [
                'aplicaciones' => collect([]),
                'ofertas' => collect([])
            ])->with('warning', 'No tienes ofertas publicadas aún.');
        }
        
        // Obtener todas las aplicaciones de las ofertas del empleador
        $query = Aplicacion::whereIn('oferta_id', $ofertas->pluck('id'))
            ->with(['empleado', 'oferta']);

        // Filtrar por oferta
        if ($request->filled('oferta')) {
            $query->where('oferta_id', $request->oferta);
        }

        // Filtrar por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Ordenar resultados
        if ($request->orden === 'antiguo') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $aplicaciones = $query->paginate(10)->withQueryString();

        return view('empleador.candidatos.index', compact('aplicaciones', 'ofertas'));
    }

    public function estadisticas()
    {
        $userId = Auth::user()->id_usuario;
        // Obtener todas las ofertas del empleador
        $ofertas = Oferta::where('empleador_id', $userId)->get();
        
        // Estadísticas básicas
        $totalOfertas = $ofertas->count();
        $ofertasActivas = $ofertas->where('estado', 'activa')->count();
        $ofertasInactivas = $ofertas->where('estado', 'inactiva')->count();
        
        // Estadísticas de aplicaciones
        $aplicaciones = Aplicacion::whereIn('oferta_id', $ofertas->pluck('id'))->get();
        $totalPostulaciones = $aplicaciones->count();
        $aplicacionesPendientes = $aplicaciones->where('estado', 'pendiente')->count();
        $aplicacionesAceptadas = $aplicaciones->where('estado', 'aceptada')->count();
        $aplicacionesRechazadas = $aplicaciones->where('estado', 'rechazada')->count();
        
        // Calcular promedio de postulantes por oferta
        $promedioPostulantes = $totalOfertas > 0 ? round($totalPostulaciones / $totalOfertas, 1) : 0;
        
        // Estadísticas por mes (últimos 6 meses)
        $estadisticasMensuales = [];
        for ($i = 5; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $mes = $fecha->format('M Y');
            
            $aplicacionesMes = Aplicacion::whereIn('oferta_id', $ofertas->pluck('id'))
                ->whereYear('created_at', $fecha->year)
                ->whereMonth('created_at', $fecha->month)
                ->count();
                
            $ofertasMes = Oferta::where('empleador_id', $userId)
                ->whereYear('created_at', $fecha->year)
                ->whereMonth('created_at', $fecha->month)
                ->count();
                
            $estadisticasMensuales[] = [
                'mes' => $mes,
                'aplicaciones' => $aplicacionesMes,
                'ofertas' => $ofertasMes
            ];
        }
        
        // Top 5 ofertas con más aplicaciones
        $topOfertas = Oferta::where('empleador_id', $userId)
            ->withCount('aplicaciones')
            ->orderBy('aplicaciones_count', 'desc')
            ->take(5)
            ->get();
            
        // Estadísticas de candidatos por estado
        $estadosCandidatos = [
            'pendiente' => $aplicacionesPendientes,
            'aceptada' => $aplicacionesAceptadas,
            'rechazada' => $aplicacionesRechazadas
        ];
        
        // Estadísticas de ofertas por estado
        $estadosOfertas = [
            'activa' => $ofertasActivas,
            'inactiva' => $ofertasInactivas
        ];
        
        return view('empleador.estadisticas', compact(
            'totalOfertas',
            'ofertasActivas',
            'ofertasInactivas',
            'totalPostulaciones',
            'aplicacionesPendientes',
            'aplicacionesAceptadas',
            'aplicacionesRechazadas',
            'promedioPostulantes',
            'estadisticasMensuales',
            'topOfertas',
            'estadosCandidatos',
            'estadosOfertas'
        ));
    }

    public function notificaciones()
    {
        return view('empleador.notificaciones');
    }

    public function configuracion()
    {
        return view('empleador.configuracion');
    }

    public function perfil()
    {
        $empleador = auth()->user();
        return view('empleador.perfil', compact('empleador'));
    }

    /**
     * Actualiza el perfil del empleador
     */
    public function actualizarPerfil(Request $request)
    {
        $request->validate([
            'nombre_empresa' => 'required|string|max:100',
            'industria' => 'required|string|max:50',
            'ubicacion' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:500',
            'sitio_web' => 'nullable|url|max:200',
            'telefono' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // 5MB
        ]);

        $usuario = Auth::user();
        $empleador = $usuario->empleador;

        if (!$empleador) {
            $empleador = new Empleador();
            $empleador->usuario_id = $usuario->id_usuario;
        }

        // Actualizar información básica
        $empleador->nombre_empresa = $request->nombre_empresa;
        $empleador->sector = $request->industria; 
        $empleador->ubicacion = $request->ubicacion;
        $empleador->descripcion = $request->descripcion;
        $empleador->sitio_web = $request->sitio_web;
        $empleador->telefono_contacto = $request->telefono;

        // Manejar logo si se subió
        if ($request->hasFile('logo')) {
            // Eliminar logo anterior si existe
            if ($empleador->logo_empresa) {
                Storage::delete('public/' . $empleador->logo_empresa);
            }

            // Guardar nuevo logo
            $path = $request->file('logo')->store('public/logos');
            $empleador->logo_empresa = str_replace('public/', '', $path);
        }

        $empleador->save();

        return redirect()->back()->with('success', 'Perfil actualizado correctamente');
    }

    public function actualizarLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $empleador = Auth::user()->empleador;

        if (!$empleador) {
             return redirect()->back()->with('error', 'No se encontró información del empleador');
        }

        if ($request->hasFile('logo')) {
            // Eliminar logo anterior si existe
            if ($empleador->logo_empresa) {
                Storage::delete('public/logos/' . basename($empleador->logo_empresa));
            }

            // Guardar nuevo logo
            $path = $request->file('logo')->store('public/logos');
            $empleador->logo_empresa = str_replace('public/', '', $path);
            $empleador->save();
        }

        return redirect()->back()->with('success', 'Logo actualizado correctamente');
    }

    public function actualizarBeneficios(Request $request)
    {
        $request->validate([
            'beneficios' => 'nullable|array',
            'beneficios.*' => 'string|max:255'
        ]);

        $empleador = Auth::user()->empleador;

        if (!$empleador) {
             return redirect()->back()->with('error', 'No se encontró información del empleador');
        }

        $empleador->beneficios = $request->beneficios ?? [];
        $empleador->save();

        return response()->json(['success' => true, 'message' => 'Beneficios actualizados correctamente']);
    }

    public function actualizarAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $usuario = Auth::user();

        if ($request->hasFile('avatar')) {
            // Eliminar avatar anterior si existe
            if ($usuario->foto_perfil) {
                Storage::delete('public/avatars/' . basename($usuario->foto_perfil));
            }

            // Guardar nuevo avatar
            $path = $request->file('avatar')->store('public/avatars');
            $usuario->foto_perfil = str_replace('public/', '', $path);
            $usuario->save();
        }

        return redirect()->back()->with('success', 'Avatar actualizado correctamente');
    }

    /**
     * Muestra el perfil de un candidato específico.
     */
    public function verCandidato(Usuario $usuario)
    {
        // Verificar que el usuario a ver sea un empleado
        if ($usuario->rol !== 'empleado') {
            abort(404);
        }

        // Cargar las aplicaciones del candidato a las ofertas del empleador actual
        $userId = Auth::user()->id_usuario;
        $aplicaciones = $usuario->aplicaciones()
            ->whereHas('oferta', function ($query) use ($userId) {
                $query->where('empleador_id', $userId);
            })
            ->with('oferta')
            ->get();

        return view('empleador.candidatos.show', compact('usuario', 'aplicaciones'));
    }

    /**
     * Actualiza el estado de una aplicación.
     */
    public function actualizarAplicacion(Request $request, Aplicacion $aplicacion)
    {
        // Verificar que la oferta pertenezca al empleador actual
        if ($aplicacion->oferta->empleador_id !== Auth::user()->id_usuario) {
            abort(403);
        }

        $request->validate([
            'estado' => 'required|in:pendiente,aceptada,rechazada'
        ]);

        $aplicacion->update([
            'estado' => $request->estado
        ]);

        return redirect()->back()->with('success', 'Estado de la aplicación actualizado correctamente');
    }
} 