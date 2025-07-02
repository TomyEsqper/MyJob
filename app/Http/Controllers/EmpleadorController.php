<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Oferta;
use App\Models\Aplicacion;
use App\Models\Usuario;
use App\Models\Empleador;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\DocumentoEmpresa;
use App\Models\Entrevista;

class EmpleadorController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::user()->id_usuario;
        
        // Obtener estadísticas del empleador
        $totalOfertas = Oferta::where('empleador_id', $userId)->count();
        $ofertasActivas = Oferta::where('empleador_id', $userId)
                               ->where('estado', 'activa')
                               ->count();
        
        $totalAplicaciones = Aplicacion::whereHas('oferta', function($query) use ($userId) {
            $query->where('empleador_id', $userId);
        })->count();

        $totalContrataciones = Aplicacion::whereHas('oferta', function($query) use ($userId) {
            $query->where('empleador_id', $userId);
        })->where('estado', 'aceptada')->count();

        // Obtener ofertas y aplicaciones recientes
        $ofertasRecientes = Oferta::where('empleador_id', $userId)
                                 ->orderBy('created_at', 'desc')
                                 ->take(5)
                                 ->get();

        $aplicacionesRecientes = Aplicacion::whereHas('oferta', function($query) use ($userId) {
            $query->where('empleador_id', $userId);
        })
        ->with(['empleado', 'oferta'])
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

        return view('empleador.dashboard', compact(
            'totalOfertas',
            'ofertasActivas',
            'totalAplicaciones',
            'totalContrataciones',
            'ofertasRecientes',
            'aplicacionesRecientes'
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

    public function configuracion()
    {
        return view('empleador.configuracion');
    }

    /**
     * Actualiza la contraseña del empleador
     */
    public function actualizarContrasena(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->contrasena)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta']);
        }

        $user->contrasena = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Contraseña actualizada correctamente');
    }

    /**
     * Elimina la cuenta del empleador y todos sus datos relacionados
     */
    public function eliminarCuenta(Request $request)
    {
        $user = Auth::user();

        // Solo validar contraseña si no es un usuario de Google
        if (!$user->google_id) {
            $request->validate([
                'password' => 'required',
            ]);

            if (!Hash::check($request->password, $user->contrasena)) {
                return back()->withErrors(['password' => 'La contraseña no es correcta']);
            }
        }

        // Comenzar transacción
        DB::beginTransaction();

        try {
            // Eliminar ofertas y sus aplicaciones
            $user->ofertas()->each(function ($oferta) {
                $oferta->aplicaciones()->delete();
                $oferta->delete();
            });

            // Eliminar el perfil de empleador
            if ($user->empleador) {
                // Eliminar logo si existe
                if ($user->empleador->logo_empresa) {
                    Storage::delete('public/logos/' . basename($user->empleador->logo_empresa));
                }
                $user->empleador->delete();
            }

            // Eliminar el usuario
            $user->delete();

            DB::commit();
            Auth::logout();

            return redirect()->route('login')->with('success', 'Tu cuenta ha sido eliminada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Hubo un error al eliminar la cuenta. Por favor, intente nuevamente.']);
        }
    }

    public function perfil()
    {
        // Obtener el usuario autenticado con su relación empleador
        $usuario = Auth::user()->load('empleador');
        $empleador = $usuario->empleador;

        // Si no existe el empleador, crear uno temporal con datos por defecto
        if (!$empleador) {
            $empleador = new Empleador([
                'usuario_id' => $usuario->id_usuario,
                'nombre_empresa' => '',
                'sector' => '',
                'ubicacion' => '',
                'descripcion' => '',
                'sitio_web' => '',
                'telefono_contacto' => '',
                'nit' => 'TEMP-' . uniqid(),
                'correo_empresarial' => $usuario->correo_electronico,
                'direccion_empresa' => 'Por definir'
            ]);
        }

        return view('empleador.perfil', compact('empleador'));
    }

    /**
     * Actualiza el perfil del empleador
     */
    public function actualizarPerfil(Request $request)
    {
        $request->validate([
            'nombre_empresa' => 'required|string|max:100',
            'nit' => 'required|string|max:20',
            'correo_empresarial' => 'required|email|max:100',
            'industria' => 'required|string|max:50',
            'ubicacion' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:500',
            'sitio_web' => 'nullable|url|max:200',
            'telefono' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $usuario = auth()->user();
        $empleador = $usuario->empleador;

        // Si no existe el empleador, crearlo
        if (!$empleador) {
            $empleador = Empleador::create([
                'usuario_id' => $usuario->id_usuario,
                'nombre_empresa' => $request->nombre_empresa,
                'nit' => $request->nit,
                'correo_empresarial' => $request->correo_empresarial,
                'sector' => $request->industria,
                'ubicacion' => $request->ubicacion,
                'descripcion' => $request->descripcion,
                'sitio_web' => $request->sitio_web,
                'telefono_contacto' => $request->telefono,
                'direccion_empresa' => $request->ubicacion
            ]);
        } else {
            // Actualizar datos básicos
            $empleador->update([
                'nombre_empresa' => $request->nombre_empresa,
                'nit' => $request->nit,
                'correo_empresarial' => $request->correo_empresarial,
                'sector' => $request->industria,
                'ubicacion' => $request->ubicacion,
                'descripcion' => $request->descripcion,
                'sitio_web' => $request->sitio_web,
                'telefono_contacto' => $request->telefono,
                'direccion_empresa' => $request->ubicacion
            ]);
        }

        // Manejar logo si se subió uno
        if ($request->hasFile('logo')) {
            // Eliminar logo anterior si existe
            if ($empleador->logo_empresa) {
                Storage::delete('public/' . $empleador->logo_empresa);
            }

            // Guardar nuevo logo
            $path = $request->file('logo')->store('public/logos');
            $empleador->logo_empresa = str_replace('public/', '', $path);
            $empleador->save();
        }

        // Manejar documento si se subió uno
        if ($request->hasFile('documento')) {
            $file = $request->file('documento');
            $nombreArchivo = time() . '_' . $file->getClientOriginalName();
            
            // Guardar el archivo
            $file->move(public_path('documentos'), $nombreArchivo);
            
            $empleador->documentos()->create([
                'nombre_archivo' => $nombreArchivo,
                'ruta_archivo' => 'documentos/' . $nombreArchivo,
                'tipo_documento' => 'general'
            ]);
        }

        return redirect()->back()->with('success', 'Perfil actualizado correctamente');
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

    public function subirDocumento(Request $request)
    {
        $request->validate([
            'documento' => 'required|file|max:10240' // 10MB máximo
        ]);

        if ($request->hasFile('documento')) {
            $usuario = auth()->user();
            $empleador = $usuario->empleador;

            // Si no existe el empleador, crear uno básico
            if (!$empleador) {
                $empleador = Empleador::create([
                    'usuario_id' => $usuario->id_usuario,
                    'nombre_empresa' => 'Empresa por definir',
                    'nit' => 'TEMP-' . uniqid(),
                    'correo_empresarial' => $usuario->correo_electronico,
                    'direccion_empresa' => 'Por definir'
                ]);
            }

            $file = $request->file('documento');
            $nombreArchivo = time() . '_' . $file->getClientOriginalName();
            
            // Guardar el archivo en storage/app/public/documentos
            $file->move(public_path('documentos'), $nombreArchivo);
            
            // Guardar la información en la base de datos
            DocumentoEmpresa::create([
                'empleador_id' => $empleador->id,
                'nombre_archivo' => $nombreArchivo,
                'ruta_archivo' => 'documentos/' . $nombreArchivo,
                'tipo_documento' => 'general'
            ]);
            
            return back()->with('success', 'Archivo subido correctamente');
        }
        
        return back()->with('error', 'Por favor selecciona un archivo');
    }

    public function eliminarDocumento(DocumentoEmpresa $documento)
    {
        if ($documento->empleador_id !== auth()->user()->empleador->id) {
            abort(403);
        }

        // Delete the file from storage
        Storage::delete('public/' . $documento->ruta_archivo);
        
        // Delete the record
        $documento->delete();

        return redirect()->back()->with('success', 'Documento eliminado correctamente.');
    }

    public function agendarEntrevista(Request $request, Aplicacion $aplicacion)
    {
        // Verificar que la aplicación pertenezca a una oferta del empleador actual y esté aceptada
        if ($aplicacion->oferta->empleador_id !== Auth::user()->id_usuario || $aplicacion->estado !== 'aceptada') {
            abort(403);
        }

        $request->validate([
            'fecha_hora' => 'required|date|after:now',
            'lugar' => 'nullable|string|max:255',
            'notas' => 'nullable|string|max:1000',
        ]);

        // Si ya existe una entrevista, actualizarla. Si no, crearla.
        $entrevista = $aplicacion->entrevista;
        if ($entrevista) {
            $entrevista->update($request->only(['fecha_hora', 'lugar', 'notas']));
        } else {
            $aplicacion->entrevista()->create($request->only(['fecha_hora', 'lugar', 'notas']));
        }

        return redirect()->back()->with('success', 'Entrevista agendada correctamente.');
    }

    public function agendaEntrevistas()
    {
        $userId = Auth::user()->id_usuario;
        $ofertasIds = \App\Models\Oferta::where('empleador_id', $userId)->pluck('id');
        $entrevistas = \App\Models\Entrevista::whereHas('aplicacion', function($q) use ($ofertasIds) {
            $q->whereIn('oferta_id', $ofertasIds);
        })->with(['aplicacion.oferta', 'aplicacion.empleado'])->orderBy('fecha_hora')->get();
        return view('empleador.agenda', compact('entrevistas'));
    }

    public function actualizarFotoPerfil(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:5120' // 5MB
        ]);

        try {
            $usuario = Auth::user();

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                
                // Crear un nombre de archivo seguro
                $extension = $file->getClientOriginalExtension();
                $nombreArchivo = time() . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $extension;
                
                // Asegurarse de que el directorio existe y tiene los permisos correctos
                $avatarPath = storage_path('app/public/avatars');
                if (!file_exists($avatarPath)) {
                    mkdir($avatarPath, 0755, true);
                }
                
                // Eliminar foto anterior si existe y no es una URL (de Google)
                if ($usuario->foto_perfil && !filter_var($usuario->foto_perfil, FILTER_VALIDATE_URL)) {
                    $oldPath = storage_path('app/public/' . $usuario->foto_perfil);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                // Guardar la nueva foto
                $file->move($avatarPath, $nombreArchivo);
                
                // Actualizar la base de datos con la ruta relativa
                $usuario->foto_perfil = 'avatars/' . $nombreArchivo;
                $usuario->save();

                // Limpiar la caché de la imagen
                clearstatcache();

                // Retornar respuesta con la nueva URL
                return redirect()->back()->with([
                    'success' => 'Foto de perfil actualizada correctamente',
                    'foto_url' => asset('storage/avatars/' . $nombreArchivo)
                ]);
            }

            return redirect()->back()->with('error', 'No se ha seleccionado ninguna imagen');
        } catch (\Exception $e) {
            \Log::error('Error al actualizar foto de perfil: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al actualizar la foto de perfil: ' . $e->getMessage());
        }
    }
} 