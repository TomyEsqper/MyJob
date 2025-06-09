<?php

namespace App\Http\Controllers;

use App\Models\Oferta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ofertas = Oferta::where('empleador_id', Auth::id())->get();
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
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'requisitos' => 'required|string',
            'salario' => 'nullable|numeric|min:0',
            'ubicacion' => 'required|string|max:255',
            'tipo_contrato' => 'required|string|max:255',
            'jornada' => 'required|string|max:255',
            'estado' => 'required|in:activa,inactiva',
        ]);

        $oferta = new Oferta($request->all());
        $oferta->empleador_id = Auth::id();
        $oferta->save();

        return redirect()->route('empleador.ofertas.index')
            ->with('success', 'Oferta creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Oferta $oferta)
    {
        if ($oferta->empleador_id !== Auth::id()) {
            abort(403);
        }
        return view('empleador.ofertas.show', compact('oferta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Oferta $oferta)
    {
        if ($oferta->empleador_id !== Auth::id()) {
            abort(403);
        }
        return view('empleador.ofertas.edit', compact('oferta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Oferta $oferta)
    {
        if ($oferta->empleador_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'requisitos' => 'required|string',
            'salario' => 'nullable|numeric|min:0',
            'ubicacion' => 'required|string|max:255',
            'tipo_contrato' => 'required|string|max:255',
            'jornada' => 'required|string|max:255',
            'estado' => 'required|in:activa,inactiva',
        ]);

        $oferta->update($request->all());

        return redirect()->route('empleador.ofertas.index')
            ->with('success', 'Oferta actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Oferta $oferta)
    {
        if ($oferta->empleador_id !== Auth::id()) {
            abort(403);
        }

        $oferta->delete();

        return redirect()->route('empleador.ofertas.index')
            ->with('success', 'Oferta eliminada correctamente');
    }

    public function dashboard()
    {
        $ofertas = \App\Models\Oferta::where('empleador_id', Auth::user()->id_usuario)->get();
        return view('empleador.dashboard', compact('ofertas'));
    }
}
