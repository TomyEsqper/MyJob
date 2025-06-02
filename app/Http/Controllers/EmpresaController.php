<?php

namespace App\Http\Controllers;

use App\Services\CamaraService;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function verificarNit(Request $request, CamaraService $camara)
    {
        $request->validate(['nit' => 'required|string']);
        $resultado = $camara->buscarPorNit($request->nit);

        if (empty($resultado)) {
            return response()->json([
                'valid' => false,
                'message' => 'NIT no registrado.'
            ], 404);
        }

        return response()->json([
            'valid' => true,
            'empresa' => $resultado[0]
        ]);
    }
}
