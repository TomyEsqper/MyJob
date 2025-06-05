<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oferta;
use Illuminate\Support\Facades\Auth;
use App\Traits\UploadTrait;
use App\Models\Usuario;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    use UploadTrait;

    public function dashboard()
    {
        $ofertas = Oferta::all(); // Obtiene todas las ofertas disponibles
        return view('empleado.dashboard', compact('ofertas'));
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
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $usuario = Auth::user();

        if ($request->hasFile('foto')) {
            // Eliminar foto anterior si existe
            if ($usuario->foto_perfil) {
                Storage::delete('public/fotos/' . basename($usuario->foto_perfil));
            }

            // Guardar nueva foto
            $path = $request->file('foto')->store('public/fotos');
            $usuario->foto_perfil = Storage::url($path);
            $usuario->save();
        }

        return redirect()->back()->with('success', 'Foto actualizada correctamente');
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
}
