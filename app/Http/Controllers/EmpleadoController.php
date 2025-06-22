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
}
