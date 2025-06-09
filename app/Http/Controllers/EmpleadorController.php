<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Oferta;
use App\Traits\UploadTrait;
use App\Models\Usuario;
use Illuminate\Support\Facades\Storage;
use App\Models\Aplicacion;

class EmpleadorController extends Controller
{
    use UploadTrait;

    public function dashboard()
    {
        $ofertas = Oferta::where('empleador_id', Auth::id())->get();
        return view('empleador.dashboard', compact('ofertas'));
    }

    public function empresa()
    {
        return view('empleador.empresa');
    }

    public function candidatos()
    {
        $ofertas = Oferta::where('empleador_id', Auth::id())
            ->with(['aplicaciones.empleado'])
            ->get();
        return view('empleador.candidatos', compact('ofertas'));
    }

    public function estadisticas()
    {
        $ofertas = Oferta::where('empleador_id', Auth::id())->get();
        $totalOfertas = $ofertas->count();
        $ofertasActivas = $ofertas->where('estado', 'activa')->count();
        $totalCandidatos = Aplicacion::whereIn('oferta_id', $ofertas->pluck('id'))->count();
        
        return view('empleador.estadisticas', compact('totalOfertas', 'ofertasActivas', 'totalCandidatos'));
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
        $empleador = Auth::user();
        return view('empleador.perfil', compact('empleador'));
    }

    /**
     * Actualiza el perfil del empleador
     */
    public function actualizarPerfil(Request $request)
    {
        $request->validate([
            'nombre_empresa' => 'required|string|max:255',
            'nit' => 'required|string|max:255',
            'correo_empresarial' => 'required|email|max:255',
            'direccion_empresa' => 'required|string',
            'telefono_contacto' => 'required|string|max:20',
            'sector' => 'nullable|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'sitio_web' => 'nullable|url|max:255',
            'numero_empleados' => 'nullable|integer|min:1',
            'descripcion' => 'nullable|string',
            'mision' => 'nullable|string',
            'vision' => 'nullable|string'
        ]);

        $empleador = auth()->user()->empleador;
        
        if (!$empleador) {
            return redirect()->back()->with('error', 'No se encontró el perfil de empleador.');
        }

        $empleador->update($request->all());

        return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function actualizarLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $usuario = Auth::user();

        if ($request->hasFile('logo')) {
            // Eliminar logo anterior si existe
            if ($usuario->logo_empresa) {
                Storage::delete('public/logos/' . basename($usuario->logo_empresa));
            }

            // Guardar nuevo logo
            $path = $request->file('logo')->store('public/logos');
            $usuario->logo_empresa = Storage::url($path);
            $usuario->save();
        }

        return redirect()->back()->with('success', 'Logo actualizado correctamente');
    }

    public function actualizarBeneficios(Request $request)
    {
        $request->validate([
            'beneficios' => 'required|array',
            'beneficios.*' => 'required|string|max:255'
        ]);

        $usuario = Auth::user();
        $usuario->beneficios = implode(',', $request->beneficios);
        $usuario->save();

        return response()->json(['success' => true, 'message' => 'Beneficios actualizados correctamente']);
    }

    public function actualizarAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $empleador = Auth::user();

        if ($request->hasFile('avatar')) {
            // Eliminar avatar anterior si existe
            if ($empleador->avatar) {
                Storage::delete('public/' . $empleador->avatar);
            }

            // Guardar nuevo avatar
            $path = $request->file('avatar')->store('avatars', 'public');
            $empleador->avatar = $path;
            $empleador->save();
        }

        return redirect()->route('empleador.perfil')->with('success', 'Avatar actualizado correctamente');
    }
} 