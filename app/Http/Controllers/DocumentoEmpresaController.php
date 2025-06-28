<?php

namespace App\Http\Controllers;

use App\Models\DocumentoEmpresa;
use App\Models\Empleador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentoEmpresaController extends Controller
{
    public function index()
    {
        $empleador = auth()->user()->empleador;
        $documentos = $empleador->documentos;
        return view('empleador.documentos.index', compact('documentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_documento' => 'required|string',
            'documento' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
        ]);

        $empleador = auth()->user()->empleador;
        $file = $request->file('documento');
        
        // Generate a unique filename while keeping the original extension
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $filename = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '_' . Str::random(10) . '.' . $extension;
        
        // Store the file in a public directory
        $path = $file->storeAs(
            'public/documentos_empresa/' . $empleador->id,
            $filename
        );

        // Create document record with the path relative to storage/app/public
        $documento = DocumentoEmpresa::create([
            'empleador_id' => $empleador->id,
            'tipo_documento' => $request->tipo_documento,
            'nombre_archivo' => $originalName,
            'ruta_archivo' => str_replace('public/', '', $path), // Remove 'public/' from the start
            'estado' => 'pendiente'
        ]);

        return redirect()->back()->with('success', 'Documento subido correctamente. Pendiente de verificación.');
    }

    public function destroy(DocumentoEmpresa $documento)
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

    public function show(DocumentoEmpresa $documento)
    {
        // Verificar que el usuario tenga permiso para ver el documento
        if ($documento->empleador_id !== auth()->user()->empleador->id && auth()->user()->rol !== 'admin') {
            abort(403);
        }

        // Verificar que el archivo exista
        if (!Storage::exists('public/' . $documento->ruta_archivo)) {
            abort(404);
        }

        // Obtener el tipo de contenido
        $mimeType = Storage::mimeType('public/' . $documento->ruta_archivo);

        // Descargar el archivo
        return Storage::download('public/' . $documento->ruta_archivo, $documento->nombre_archivo, [
            'Content-Type' => $mimeType,
        ]);
    }

    public function verificar(Request $request, DocumentoEmpresa $documento)
    {
        if (!auth()->user()->rol === 'admin') {
            abort(403);
        }

        $request->validate([
            'estado' => 'required|in:aprobado,rechazado',
            'comentarios_admin' => 'nullable|string|max:500'
        ]);

        $documento->update([
            'estado' => $request->estado,
            'comentarios_admin' => $request->comentarios_admin
        ]);

        return redirect()->back()->with('success', 'Documento verificado correctamente.');
    }
} 