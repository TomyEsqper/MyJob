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

class EmpleadoController extends Controller
{
    use UploadTrait;

    public function dashboard()
    {
        $usuario = Auth::user();
        
        // Get statistics
        $aplicacionesEnviadas = $usuario->aplicaciones()->count();
        $vistasPerfilCount = 45; // TODO: Implement profile views tracking
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

    public function perfil()
    {
        return view('empleado.perfil');
    }

    public function actualizarPerfil(Request $request)
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
        ]);

        $usuario = Auth::user();
        $usuario->update($request->all());

        return redirect()->back()->with('success', 'Perfil actualizado correctamente');
    }

    public function actualizarFoto(Request $request)
    {
        Log::info('Iniciando actualización de foto');
        
        try {
            DB::beginTransaction();
            
            $request->validate([
                'foto' => [
                    'required',
                    'image',
                    'mimes:jpeg,png,jpg,gif',
                    'max:2048',
                    'dimensions:min_width=150,min_height=150,max_width=2000,max_height=2000'
                ]
            ], [
                'foto.required' => 'Por favor, selecciona una foto.',
                'foto.image' => 'El archivo debe ser una imagen.',
                'foto.mimes' => 'La foto debe ser de tipo: jpeg, png, jpg o gif.',
                'foto.max' => 'La foto no debe pesar más de 2MB.',
                'foto.dimensions' => 'La foto debe tener un tamaño mínimo de 150x150 píxeles y máximo de 2000x2000 píxeles.'
            ]);

            Log::info('Validación pasada correctamente');
            
            $usuario = Auth::user();
            Log::info('Usuario obtenido', [
                'id' => $usuario->id_usuario,
                'foto_actual' => $usuario->foto_perfil
            ]);

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                
                Log::info('Archivo de foto recibido', [
                    'nombre_original' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'tamaño' => $file->getSize()
                ]);
                
                // Eliminar foto anterior si existe
                if ($usuario->foto_perfil) {
                    $oldPath = str_replace('/storage/', 'public/', $usuario->foto_perfil);
                    Log::info('Intentando eliminar foto anterior', ['path' => $oldPath]);
                    if (Storage::exists($oldPath)) {
                        Storage::delete($oldPath);
                        Log::info('Foto anterior eliminada correctamente');
                    } else {
                        Log::warning('No se encontró la foto anterior para eliminar');
                    }
                }

                // Guardar nueva foto
                $fileName = time() . '_' . $file->getClientOriginalName();
                Log::info('Intentando guardar nueva foto', ['fileName' => $fileName]);
                
                // Asegurarse de que el directorio existe
                Storage::makeDirectory('public/fotos');
                
                $path = $file->storeAs('public/fotos', $fileName);
                Log::info('Foto guardada', ['path' => $path]);
                
                if (!Storage::exists($path)) {
                    throw new \Exception('El archivo no se guardó correctamente');
                }
                
                // Actualizar la ruta en la base de datos
                $usuario->foto_perfil = '/storage/' . str_replace('public/', '', $path);
                Log::info('Actualizando ruta en base de datos', ['url' => $usuario->foto_perfil]);
                
                $saved = $usuario->save();
                Log::info('Resultado del guardado', [
                    'saved' => $saved,
                    'usuario' => $usuario->toArray()
                ]);

                if (!$saved) {
                    throw new \Exception('No se pudo guardar en la base de datos');
                }

                DB::commit();
                Log::info('Transacción completada correctamente');

                return redirect()->back()->with('success', 'Foto actualizada correctamente');
            }

            Log::warning('No se recibió archivo de foto');
            return redirect()->back()->with('error', 'No se ha seleccionado ninguna foto');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al procesar la foto', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Error al procesar la foto: ' . $e->getMessage());
        }
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
}
