<?php

namespace App\Http\Controllers;

use App\Models\Oferta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OfertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ofertas = Oferta::where('empleador_id', Auth::user()->id_usuario)->get();
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
        Log::info('Datos recibidos en store:', $request->all());
        Log::info('Usuario autenticado:', ['user_id' => Auth::user()->id_usuario ?? 'null', 'user' => Auth::user()]);
        Log::info('Beneficios recibidos:', ['beneficios' => $request->input('beneficios')]);
        Log::info('Estado recibido:', ['estado' => $request->input('estado')]);
        
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|min:100',
            'requisitos' => 'required|string|min:50',
            'responsabilidades' => 'nullable|string|max:2000',
            'salario' => 'nullable|numeric|min:0',
            'salario_max' => 'nullable|numeric|min:0',
            'ubicacion' => 'required|string|max:255',
            'tipo_contrato' => 'required|string|max:255',
            'jornada' => 'required|string|max:255',
            'estado' => 'required|in:activa,inactiva',
            'nivel_experiencia' => 'required|string|in:' . implode(',', array_keys(Oferta::getNivelesExperiencia())),
            'categoria' => 'required|string|in:' . implode(',', array_keys(Oferta::getCategorias())),
            'beneficios' => 'nullable|array',
            'beneficios.*' => 'in:' . implode(',', array_keys(Oferta::getBeneficiosDisponibles())),
            'modalidad_trabajo' => 'required|string|in:' . implode(',', array_keys(Oferta::getModalidadesTrabajo())),
            'fecha_limite' => 'nullable|date|after_or_equal:today'
        ]);

        Log::info('Validación pasada correctamente');

        // Validación personalizada para salarios
        if ($request->filled('salario') && $request->filled('salario_max')) {
            if ($request->salario_max <= $request->salario) {
                Log::error('Error en validación de salarios');
                return back()->withErrors(['salario_max' => 'El salario máximo debe ser mayor que el salario mínimo.'])->withInput();
            }
        }

        // Manejar beneficios vacíos
        $beneficios = $request->input('beneficios');
        if (empty($beneficios)) {
            $beneficios = [];
        }

        // Manejar responsabilidades vacías
        $responsabilidades = $request->input('responsabilidades');
        if (empty($responsabilidades)) {
            $responsabilidades = null;
        }

        // Manejar fecha_limite vacía
        $fecha_limite = $request->input('fecha_limite');
        if (empty($fecha_limite)) {
            $fecha_limite = null;
        }

        // Manejar salario vacío
        $salario = $request->input('salario');
        if (empty($salario)) {
            $salario = null;
        }

        try {
            $data = $request->all();
            $data['beneficios'] = $beneficios;
            $data['responsabilidades'] = $responsabilidades;
            $data['fecha_limite'] = $fecha_limite;
            $data['salario'] = $salario;
            
            Log::info('Datos finales para crear oferta:', $data);
            Log::info('Empleador ID:', ['empleador_id' => Auth::user()->id_usuario]);
            
            $oferta = new Oferta($data);
            $oferta->empleador_id = Auth::user()->id_usuario;
            $oferta->save();
            
            Log::info('Oferta creada exitosamente', ['oferta_id' => $oferta->id]);

            return redirect()->route('empleador.ofertas.index')
                ->with('success', 'Oferta creada correctamente');
        } catch (\Exception $e) {
            Log::error('Error al crear oferta: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error al crear la oferta: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Oferta $oferta)
    {
        if ($oferta->empleador_id !== Auth::user()->id_usuario) {
            abort(403);
        }
        return view('empleador.ofertas.show', compact('oferta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Oferta $oferta)
    {
        if ($oferta->empleador_id !== Auth::user()->id_usuario) {
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
        if ($oferta->empleador_id !== Auth::user()->id_usuario) {
            abort(403);
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|min:100',
            'requisitos' => 'required|string|min:50',
            'responsabilidades' => 'nullable|string|max:2000',
            'salario' => 'required|numeric|min:0',
            'ubicacion' => 'required|string|max:255',
            'tipo_contrato' => 'required|string|max:255',
            'jornada' => 'required|string|max:255',
            'estado' => 'required|in:activa,inactiva',
            'nivel_experiencia' => 'required|string|in:' . implode(',', array_keys(Oferta::getNivelesExperiencia())),
            'categoria' => 'required|string|in:' . implode(',', array_keys(Oferta::getCategorias())),
            'beneficios' => 'nullable|array',
            'beneficios.*' => 'in:' . implode(',', array_keys(Oferta::getBeneficiosDisponibles())),
            'modalidad_trabajo' => 'required|string|in:' . implode(',', array_keys(Oferta::getModalidadesTrabajo())),
            'fecha_limite' => 'nullable|date|after_or_equal:today'
        ]);

        // Manejar beneficios vacíos
        $beneficios = $request->input('beneficios');
        if (empty($beneficios)) {
            $beneficios = [];
        }

        // Manejar responsabilidades vacías
        $responsabilidades = $request->input('responsabilidades');
        if (empty($responsabilidades)) {
            $responsabilidades = null;
        }

        // Manejar fecha_limite vacía
        $fecha_limite = $request->input('fecha_limite');
        if (empty($fecha_limite)) {
            $fecha_limite = null;
        }

        // Manejar salario vacío
        $salario = $request->input('salario');
        if (empty($salario)) {
            $salario = null;
        }

        $data = $request->all();
        $data['beneficios'] = $beneficios;
        $data['responsabilidades'] = $responsabilidades;
        $data['fecha_limite'] = $fecha_limite;
        $data['salario'] = $salario;
        
        $oferta->update($data);

        return redirect()->route('empleador.ofertas.index')
            ->with('success', 'Oferta actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Oferta $oferta)
    {
        if ($oferta->empleador_id !== Auth::user()->id_usuario) {
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
