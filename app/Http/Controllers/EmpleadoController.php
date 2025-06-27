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
use App\Models\Experiencia;
use App\Models\Educacion;
use App\Models\Certificado;
use App\Models\Idioma;

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
            'profesion' => 'nullable|string|max:255',
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
            'nombre_usuario.required' => '¡Ups! El nombre completo es obligatorio para tu perfil.',
            'nombre_usuario.max' => 'El nombre no puede tener más de 255 caracteres.',
            'profesion.max' => 'La profesión no puede tener más de 255 caracteres.',
            'telefono.max' => 'El teléfono no puede tener más de 20 caracteres.',
            'whatsapp.max' => 'El WhatsApp no puede superar 30 caracteres.',
            'facebook.max' => 'El Facebook no puede superar 100 caracteres.',
            'instagram.max' => 'El Instagram no puede superar 100 caracteres.',
            'linkedin.max' => 'El LinkedIn no puede superar 100 caracteres.',
            'resumen_profesional.max' => 'El resumen profesional no puede superar 1000 caracteres.',
        ]);

        try {
            $usuario = Usuario::findOrFail($id);
            
            // Solo actualizar los campos que vienen en el request
            $camposActualizados = [];
            
            if ($request->has('nombre_usuario')) {
                $usuario->nombre_usuario = $request->nombre_usuario;
                $camposActualizados[] = 'nombre';
            }
            
            if ($request->has('profesion')) {
                $usuario->profesion = $request->profesion;
                $camposActualizados[] = 'profesión';
            }
            
            if ($request->has('telefono')) {
                $usuario->telefono = $request->telefono;
                $camposActualizados[] = 'teléfono';
            }
            
            if ($request->has('resumen_profesional')) {
                $usuario->resumen_profesional = $request->resumen_profesional;
                $camposActualizados[] = 'resumen profesional';
            }
            
            if ($request->has('descripcion')) {
                $usuario->descripcion = $request->descripcion;
            }
            
            if ($request->has('experiencia')) {
                $usuario->experiencia = $request->experiencia;
            }
            
            if ($request->has('educacion')) {
                $usuario->educacion = $request->educacion;
            }
            
            if ($request->has('ubicacion')) {
                $usuario->ubicacion = $request->ubicacion;
            }
            
            if ($request->has('habilidades')) {
                $usuario->habilidades = $request->habilidades;
            }
            
            if ($request->has('whatsapp')) {
                $usuario->whatsapp = $request->whatsapp;
            }
            
            if ($request->has('facebook')) {
                $usuario->facebook = $request->facebook;
            }
            
            if ($request->has('instagram')) {
                $usuario->instagram = $request->instagram;
            }
            
            if ($request->has('linkedin')) {
                $usuario->linkedin = $request->linkedin;
            }
            
            if ($request->has('disponibilidad_horario')) {
                $usuario->disponibilidad_horario = $request->disponibilidad_horario;
            }
            
            if ($request->has('disponibilidad_jornada')) {
                $usuario->disponibilidad_jornada = $request->disponibilidad_jornada;
            }
            
            if ($request->has('disponibilidad_movilidad')) {
                $usuario->disponibilidad_movilidad = $request->has('disponibilidad_movilidad') ? (bool)$request->disponibilidad_movilidad : null;
            }
            
            $usuario->save();

            // Mensaje personalizado según qué campos se actualizaron
            if (empty($camposActualizados)) {
                $mensaje = 'No se detectaron cambios en tu perfil.';
            } elseif (count($camposActualizados) === 1) {
                $mensaje = "¡Perfecto! Tu {$camposActualizados[0]} ha sido actualizado correctamente.";
            } else {
                $ultimoCampo = array_pop($camposActualizados);
                $camposTexto = implode(', ', $camposActualizados) . ' y ' . $ultimoCampo;
                $mensaje = "¡Excelente! Tus datos han sido actualizados: {$camposTexto}.";
            }

            return redirect()->back()->with('success', $mensaje);
            
        } catch (\Exception $e) {
            Log::error('Error al actualizar perfil: ' . $e->getMessage());
            return redirect()->back()->with('error', '¡Ups! Hubo un problema al guardar tus cambios. Intenta nuevamente.');
        }
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
        Log::info('Iniciando actualización de habilidades', [
            'request_data' => $request->all(),
            'user_id' => Auth::id()
        ]);

        $request->validate([
            'habilidades_json' => 'required|string',
        ], [
            'habilidades_json.required' => 'Debes proporcionar al menos una habilidad.',
        ]);

        try {
            // Decodificar el JSON de habilidades
            $habilidadesArray = json_decode($request->habilidades_json, true);
            
            Log::info('Habilidades decodificadas', [
                'habilidades_json' => $request->habilidades_json,
                'habilidades_array' => $habilidadesArray
            ]);
            
            if (!is_array($habilidadesArray)) {
                Log::error('Formato de habilidades inválido', [
                    'habilidades_received' => $request->habilidades_json
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Formato de datos inválido. Intenta nuevamente.'
                ], 400);
            }

            // Validar que no esté vacío
            if (empty($habilidadesArray)) {
                Log::warning('Array de habilidades vacío');
                
                return response()->json([
                    'success' => false,
                    'message' => 'Debes agregar al menos una habilidad.'
                ], 400);
            }

            // Validar cada habilidad
            $habilidadesValidas = [];
            foreach ($habilidadesArray as $habilidad) {
                $habilidad = trim($habilidad);
                if (!empty($habilidad) && strlen($habilidad) <= 100) {
                    $habilidadesValidas[] = $habilidad;
                }
            }

            Log::info('Habilidades validadas', [
                'habilidades_validas' => $habilidadesValidas
            ]);

            if (empty($habilidadesValidas)) {
                Log::warning('No se encontraron habilidades válidas');
                
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron habilidades válidas. Asegúrate de que no estén vacías.'
                ], 400);
            }

            // Eliminar duplicados manteniendo el orden
            $habilidadesUnicas = array_values(array_unique($habilidadesValidas));

            // Obtener el usuario actual
            $usuario = Auth::user();
            
            // Obtener habilidades anteriores para comparar
            $habilidadesAnteriores = $usuario->habilidades ? explode(',', $usuario->habilidades) : [];
            
            Log::info('Comparando habilidades', [
                'habilidades_anteriores' => $habilidadesAnteriores,
                'habilidades_nuevas' => $habilidadesUnicas
            ]);
            
            // Actualizar las habilidades
            $usuario->habilidades = implode(',', $habilidadesUnicas);
            $usuario->save();

            Log::info('Habilidades guardadas exitosamente', [
                'usuario_id' => $usuario->id_usuario,
                'habilidades_guardadas' => $usuario->habilidades
            ]);

            // Preparar mensaje personalizado
            $cantidadHabilidades = count($habilidadesUnicas);
            $habilidadesAgregadas = array_diff($habilidadesUnicas, $habilidadesAnteriores);
            $habilidadesEliminadas = array_diff($habilidadesAnteriores, $habilidadesUnicas);

            if (empty($habilidadesAnteriores)) {
                $mensaje = "¡Perfecto! Has agregado {$cantidadHabilidades} " . ($cantidadHabilidades === 1 ? 'habilidad' : 'habilidades') . " a tu perfil.";
            } elseif (!empty($habilidadesAgregadas) && !empty($habilidadesEliminadas)) {
                $mensaje = "¡Excelente! Has actualizado tus habilidades. Agregaste " . count($habilidadesAgregadas) . " y eliminaste " . count($habilidadesEliminadas) . ".";
            } elseif (!empty($habilidadesAgregadas)) {
                $mensaje = "¡Genial! Has agregado " . count($habilidadesAgregadas) . " nueva" . (count($habilidadesAgregadas) === 1 ? '' : 's') . " habilidad" . (count($habilidadesAgregadas) === 1 ? '' : 'es') . ".";
            } elseif (!empty($habilidadesEliminadas)) {
                $mensaje = "Has eliminado " . count($habilidadesEliminadas) . " habilidad" . (count($habilidadesEliminadas) === 1 ? '' : 'es') . " de tu perfil.";
            } else {
                $mensaje = "Tus habilidades han sido actualizadas correctamente.";
            }

            $response = [
                'success' => true,
                'message' => $mensaje,
                'habilidades' => $habilidadesUnicas,
                'cantidad' => $cantidadHabilidades
            ];

            Log::info('Respuesta exitosa', $response);

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error al actualizar habilidades: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all(),
                'user_id' => Auth::id()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => '¡Ups! Hubo un problema al guardar tus habilidades. Intenta nuevamente.'
            ], 500);
        }
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

    // EXPERIENCIA
    public function storeExperiencia(Request $request) {
        Log::info('=== INICIO storeExperiencia ===');
        Log::info('Método HTTP: ' . $request->method());
        Log::info('Headers: ' . json_encode($request->headers->all()));
        Log::info('Datos recibidos: ' . json_encode($request->all()));
        Log::info('Content-Type: ' . $request->header('Content-Type'));
        Log::info('Accept: ' . $request->header('Accept'));
        
        $request->validate([
            'puesto' => 'required|string|max:255',
            'empresa' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'descripcion' => 'nullable|string',
            'logro' => 'nullable|string|max:255',
        ], [
            'puesto.required' => 'El puesto es obligatorio',
            'empresa.required' => 'La empresa es obligatoria',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser posterior o igual a la fecha de inicio',
        ]);

        try {
            $periodo = $request->fecha_inicio;
            if ($request->fecha_fin) {
                $periodo .= ' - ' . $request->fecha_fin;
            } else {
                $periodo .= ' - Presente';
            }

            $experiencia = Experiencia::create([
                'usuario_id' => Auth::id(),
                'puesto' => $request->puesto,
                'empresa' => $request->empresa,
                'periodo' => $periodo,
                'descripcion' => $request->descripcion,
                'logro' => $request->logro,
            ]);

            Log::info('Experiencia creada exitosamente: ' . json_encode($experiencia->toArray()));

            if ($request->ajax() || $request->wantsJson()) {
                Log::info('Respondiendo con JSON');
                return response()->json([
                    'success' => true,
                    'message' => 'Experiencia agregada correctamente',
                    'data' => $experiencia
                ]);
            }
            
            Log::info('Respondiendo con redirect');
            return back()->with('success', 'Experiencia agregada correctamente');
        } catch (\Exception $e) {
            Log::error('Error al crear experiencia: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al agregar experiencia: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Error al agregar experiencia');
        }
    }

    public function updateExperiencia(Request $request, $id) {
        $exp = Experiencia::where('usuario_id', Auth::id())->findOrFail($id);
        $request->validate([
            'puesto' => 'required|string|max:255',
            'empresa' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'descripcion' => 'nullable|string',
            'logro' => 'nullable|string|max:255',
        ]);

        try {
            $periodo = $request->fecha_inicio;
            if ($request->fecha_fin) {
                $periodo .= ' - ' . $request->fecha_fin;
            } else {
                $periodo .= ' - Presente';
            }

            $exp->update([
                'puesto' => $request->puesto,
                'empresa' => $request->empresa,
                'periodo' => $periodo,
                'descripcion' => $request->descripcion,
                'logro' => $request->logro,
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Experiencia actualizada correctamente'
                ]);
            }
            return back()->with('success', 'Experiencia actualizada correctamente');
        } catch (\Exception $e) {
            Log::error('Error al actualizar experiencia: ' . $e->getMessage());
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar experiencia'
                ], 500);
            }
            return back()->with('error', 'Error al actualizar experiencia');
        }
    }

    public function destroyExperiencia($id) {
        try {
            $exp = Experiencia::where('usuario_id', Auth::id())->findOrFail($id);
            $exp->delete();
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Experiencia eliminada correctamente'
                ]);
            }
            return back()->with('success', 'Experiencia eliminada correctamente');
        } catch (\Exception $e) {
            Log::error('Error al eliminar experiencia: ' . $e->getMessage());
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar experiencia'
                ], 500);
            }
            return back()->with('error', 'Error al eliminar experiencia');
        }
    }

    // EDUCACION
    public function storeEducacion(Request $request) {
        Log::info('Datos recibidos en storeEducacion:', $request->all());
        
        $request->validate([
            'titulo' => 'required|string|max:255',
            'institucion' => 'required|string|max:255',
            'fecha_inicio_edu' => 'required|date',
            'fecha_fin_edu' => 'nullable|date|after_or_equal:fecha_inicio_edu',
            'descripcion_edu' => 'nullable|string',
        ], [
            'titulo.required' => 'El título es obligatorio',
            'institucion.required' => 'La institución es obligatoria',
            'fecha_inicio_edu.required' => 'La fecha de inicio es obligatoria',
            'fecha_fin_edu.after_or_equal' => 'La fecha de fin debe ser posterior o igual a la fecha de inicio',
        ]);

        try {
            $periodo = $request->fecha_inicio_edu;
            if ($request->fecha_fin_edu) {
                $periodo .= ' - ' . $request->fecha_fin_edu;
            } else {
                $periodo .= ' - Presente';
            }

            $educacion = Educacion::create([
                'usuario_id' => Auth::id(),
                'titulo' => $request->titulo,
                'institucion' => $request->institucion,
                'periodo' => $periodo,
                'descripcion' => $request->descripcion_edu,
            ]);

            Log::info('Educación creada exitosamente:', $educacion->toArray());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Educación agregada correctamente',
                    'data' => $educacion
                ]);
            }
            return back()->with('success', 'Educación agregada correctamente');
        } catch (\Exception $e) {
            Log::error('Error al crear educación: ' . $e->getMessage());
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al agregar educación: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Error al agregar educación');
        }
    }

    public function updateEducacion(Request $request, $id) {
        $edu = Educacion::where('usuario_id', Auth::id())->findOrFail($id);
        $request->validate([
            'titulo' => 'required|string|max:255',
            'institucion' => 'required|string|max:255',
            'fecha_inicio_edu' => 'required|date',
            'fecha_fin_edu' => 'nullable|date|after_or_equal:fecha_inicio_edu',
            'descripcion_edu' => 'nullable|string',
        ]);

        try {
            $periodo = $request->fecha_inicio_edu;
            if ($request->fecha_fin_edu) {
                $periodo .= ' - ' . $request->fecha_fin_edu;
            } else {
                $periodo .= ' - Presente';
            }

            $edu->update([
                'titulo' => $request->titulo,
                'institucion' => $request->institucion,
                'periodo' => $periodo,
                'descripcion' => $request->descripcion_edu,
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Educación actualizada correctamente'
                ]);
            }
            return back()->with('success', 'Educación actualizada correctamente');
        } catch (\Exception $e) {
            Log::error('Error al actualizar educación: ' . $e->getMessage());
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar educación'
                ], 500);
            }
            return back()->with('error', 'Error al actualizar educación');
        }
    }

    public function destroyEducacion($id) {
        try {
            $edu = Educacion::where('usuario_id', Auth::id())->findOrFail($id);
            $edu->delete();
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Educación eliminada correctamente'
                ]);
            }
            return back()->with('success', 'Educación eliminada correctamente');
        } catch (\Exception $e) {
            Log::error('Error al eliminar educación: ' . $e->getMessage());
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar educación'
                ], 500);
            }
            return back()->with('error', 'Error al eliminar educación');
        }
    }

    // CERTIFICADOS
    public function storeCertificado(Request $request) {
        Log::info('Datos recibidos en storeCertificado:', $request->all());
        
        $request->validate([
            'nombre_cert' => 'required|string|max:255',
            'emisor' => 'required|string|max:255',
            'fecha_emision_cert' => 'required|date',
            'fecha_vencimiento_cert' => 'nullable|date|after_or_equal:fecha_emision_cert',
            'descripcion_cert' => 'nullable|string',
        ], [
            'nombre_cert.required' => 'El nombre del certificado es obligatorio',
            'emisor.required' => 'El emisor es obligatorio',
            'fecha_emision_cert.required' => 'La fecha de emisión es obligatoria',
            'fecha_vencimiento_cert.after_or_equal' => 'La fecha de vencimiento debe ser posterior o igual a la fecha de emisión',
        ]);

        try {
            $certificado = Certificado::create([
                'usuario_id' => Auth::id(),
                'nombre' => $request->nombre_cert,
                'emisor' => $request->emisor,
                'fecha_emision' => $request->fecha_emision_cert,
                'fecha_vencimiento' => $request->fecha_vencimiento_cert,
                'descripcion' => $request->descripcion_cert,
            ]);

            Log::info('Certificado creado exitosamente:', $certificado->toArray());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Certificado agregado correctamente',
                    'data' => $certificado
                ]);
            }
            return back()->with('success', 'Certificado agregado correctamente');
        } catch (\Exception $e) {
            Log::error('Error al crear certificado: ' . $e->getMessage());
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al agregar certificado: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Error al agregar certificado');
        }
    }

    public function updateCertificado(Request $request, $id) {
        $cert = Certificado::where('usuario_id', Auth::id())->findOrFail($id);
        $request->validate([
            'nombre_cert' => 'required|string|max:255',
            'emisor' => 'required|string|max:255',
            'fecha_emision_cert' => 'required|date',
            'fecha_vencimiento_cert' => 'nullable|date|after_or_equal:fecha_emision_cert',
            'descripcion_cert' => 'nullable|string',
        ]);

        try {
            $cert->update([
                'nombre' => $request->nombre_cert,
                'emisor' => $request->emisor,
                'fecha_emision' => $request->fecha_emision_cert,
                'fecha_vencimiento' => $request->fecha_vencimiento_cert,
                'descripcion' => $request->descripcion_cert,
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Certificado actualizado correctamente'
                ]);
            }
            return back()->with('success', 'Certificado actualizado correctamente');
        } catch (\Exception $e) {
            Log::error('Error al actualizar certificado: ' . $e->getMessage());
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar certificado'
                ], 500);
            }
            return back()->with('error', 'Error al actualizar certificado');
        }
    }

    public function destroyCertificado($id) {
        try {
            $cert = Certificado::where('usuario_id', Auth::id())->findOrFail($id);
            $cert->delete();
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Certificado eliminado correctamente'
                ]);
            }
            return back()->with('success', 'Certificado eliminado correctamente');
        } catch (\Exception $e) {
            Log::error('Error al eliminar certificado: ' . $e->getMessage());
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar certificado'
                ], 500);
            }
            return back()->with('error', 'Error al eliminar certificado');
        }
    }

    // IDIOMAS
    public function storeIdioma(Request $request) {
        Log::info('Datos recibidos en storeIdioma:', $request->all());
        
        $request->validate([
            'idioma' => 'required|string|max:100',
            'nivel' => 'required|string|max:100',
            'descripcion_idioma' => 'nullable|string',
        ], [
            'idioma.required' => 'El idioma es obligatorio',
            'nivel.required' => 'El nivel es obligatorio',
        ]);

        try {
            $idioma = Idioma::create([
                'usuario_id' => Auth::id(),
                'idioma' => $request->idioma,
                'nivel' => $request->nivel,
                'descripcion' => $request->descripcion_idioma,
            ]);

            Log::info('Idioma creado exitosamente:', $idioma->toArray());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Idioma agregado correctamente',
                    'data' => $idioma
                ]);
            }
            return back()->with('success', 'Idioma agregado correctamente');
        } catch (\Exception $e) {
            Log::error('Error al crear idioma: ' . $e->getMessage());
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al agregar idioma: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Error al agregar idioma');
        }
    }

    public function updateIdioma(Request $request, $id) {
        $idioma = Idioma::where('usuario_id', Auth::id())->findOrFail($id);
        $request->validate([
            'idioma' => 'required|string|max:100',
            'nivel' => 'required|string|max:100',
            'descripcion_idioma' => 'nullable|string',
        ]);

        try {
            $idioma->update([
                'idioma' => $request->idioma,
                'nivel' => $request->nivel,
                'descripcion' => $request->descripcion_idioma,
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Idioma actualizado correctamente'
                ]);
            }
            return back()->with('success', 'Idioma actualizado correctamente');
        } catch (\Exception $e) {
            Log::error('Error al actualizar idioma: ' . $e->getMessage());
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar idioma'
                ], 500);
            }
            return back()->with('error', 'Error al actualizar idioma');
        }
    }

    public function destroyIdioma($id) {
        try {
            $idioma = Idioma::where('usuario_id', Auth::id())->findOrFail($id);
            $idioma->delete();
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Idioma eliminado correctamente'
                ]);
            }
            return back()->with('success', 'Idioma eliminado correctamente');
        } catch (\Exception $e) {
            Log::error('Error al eliminar idioma: ' . $e->getMessage());
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar idioma'
                ], 500);
            }
            return back()->with('error', 'Error al eliminar idioma');
        }
    }
}
