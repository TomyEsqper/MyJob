<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Oferta;
use App\Traits\UploadTrait;
use App\Models\Usuario;
use Illuminate\Support\Facades\Storage;

class EmpleadorController extends Controller
{
    use UploadTrait;

    public function dashboard()
    {
        $ofertas = Oferta::where('empleador_id', Auth::id())->get();
        return view('empleador.dashboard', compact('ofertas'));
    }

    public function perfil()
    {
        return view('empleador.perfil');
    }

    public function actualizarPerfil(Request $request)
    {
        $request->validate([
            'nombre_empresa' => 'required|string|max:255',
            'sector' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'mision' => 'nullable|string',
            'vision' => 'nullable|string',
            'telefono' => 'nullable|string|max:20',
            'ubicacion' => 'nullable|string|max:255',
            'sitio_web' => 'nullable|url|max:255',
            'numero_empleados' => 'nullable|integer',
            'beneficios' => 'nullable|string',
        ]);

        $usuario = Auth::user();
        $usuario->update($request->all());

        return redirect()->back()->with('success', 'Perfil actualizado correctamente');
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
} 