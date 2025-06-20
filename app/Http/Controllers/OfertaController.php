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
        $nivelesExperiencia = Oferta::getNivelesExperiencia();
        $modalidadesTrabajo = Oferta::getModalidadesTrabajo();
        $categorias = Oferta::getCategorias();
        $beneficiosDisponibles = Oferta::getBeneficiosDisponibles();
        
        return view('empleador.ofertas.create', compact(
            'nivelesExperiencia',
            'modalidadesTrabajo',
            'categorias',
            'beneficiosDisponibles'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|min:100',
            'requisitos' => 'required|string|min:50',
            'salario' => 'nullable|numeric|min:0',
            'salario_max' => 'nullable|numeric|min:0|gt:salario',
            'ubicacion' => 'required|string|max:255',
            'tipo_contrato' => 'required|string|max:255',
            'jornada' => 'required|string|max:255',
            'estado' => 'required|in:activa,inactiva',
            'nivel_experiencia' => 'required|string|in:' . implode(',', array_keys(Oferta::getNivelesExperiencia())),
            'categoria' => 'required|string|in:' . implode(',', array_keys(Oferta::getCategorias())),
            'beneficios' => 'nullable|array',
            'beneficios.*' => 'in:' . implode(',', array_keys(Oferta::getBeneficiosDisponibles())),
            'modalidad_trabajo' => 'required|string|in:' . implode(',', array_keys(Oferta::getModalidadesTrabajo())),
            'fecha_limite' => 'nullable|date|after:today'
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

        $nivelesExperiencia = Oferta::getNivelesExperiencia();
        $modalidadesTrabajo = Oferta::getModalidadesTrabajo();
        $categorias = Oferta::getCategorias();
        $beneficiosDisponibles = Oferta::getBeneficiosDisponibles();
        
        return view('empleador.ofertas.edit', compact(
            'oferta',
            'nivelesExperiencia',
            'modalidadesTrabajo',
            'categorias',
            'beneficiosDisponibles'
        ));
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
            'descripcion' => 'required|string|min:100',
            'requisitos' => 'required|string|min:50',
            'salario' => 'nullable|numeric|min:0',
            'salario_max' => 'nullable|numeric|min:0|gt:salario',
            'ubicacion' => 'required|string|max:255',
            'tipo_contrato' => 'required|string|max:255',
            'jornada' => 'required|string|max:255',
            'estado' => 'required|in:activa,inactiva',
            'nivel_experiencia' => 'required|string|in:' . implode(',', array_keys(Oferta::getNivelesExperiencia())),
            'categoria' => 'required|string|in:' . implode(',', array_keys(Oferta::getCategorias())),
            'beneficios' => 'nullable|array',
            'beneficios.*' => 'in:' . implode(',', array_keys(Oferta::getBeneficiosDisponibles())),
            'modalidad_trabajo' => 'required|string|in:' . implode(',', array_keys(Oferta::getModalidadesTrabajo())),
            'fecha_limite' => 'nullable|date|after:today'
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
