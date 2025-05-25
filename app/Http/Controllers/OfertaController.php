<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ofertas = \App\Models\Oferta::where('empleador_id', Auth::user()->id_usuario)->get();
        return view('empleador.ofertas.index', compact('ofertas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('empleador.ofertas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'ubicacion' => 'required|string|max:255',
            'salario' => 'nullable|numeric',
            'tipo_contrato' => 'required|string|max:100',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);
        $validated['empleador_id'] = Auth::user()->id_usuario;
        \App\Models\Oferta::create($validated);
        return redirect()->route('ofertas.index')->with('success', 'Oferta creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $oferta = \App\Models\Oferta::where('empleador_id', Auth::user()->id_usuario)->findOrFail($id);
        return view('empleador.ofertas.edit', compact('oferta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $oferta = \App\Models\Oferta::where('empleador_id', Auth::user()->id_usuario)->findOrFail($id);
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'ubicacion' => 'required|string|max:255',
            'salario' => 'nullable|numeric',
            'tipo_contrato' => 'required|string|max:100',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);
        $oferta->update($validated);
        return redirect()->route('ofertas.index')->with('success', 'Oferta actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $oferta = \App\Models\Oferta::where('empleador_id', Auth::user()->id_usuario)->findOrFail($id);
        $oferta->delete();
        return redirect()->route('ofertas.index')->with('success', 'Oferta eliminada correctamente.');
    }
    public function dashboard()
    {
        $ofertas = \App\Models\Oferta::where('empleador_id', Auth::user()->id_usuario)->get();
        return view('empleador.dashboard', compact('ofertas'));
    }
}
