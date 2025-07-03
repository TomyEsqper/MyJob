<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class PqrsController extends Controller
{
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'tipo' => 'required|in:Pregunta,Queja,Reclamo,Sugerencia',
            'mensaje' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = [
            'nombre' => $request->nombre,
            'email' => $request->email,
            'tipo' => $request->tipo,
            'mensaje' => $request->mensaje,
        ];

        try {
            // Usar la plantilla Blade para el correo
            Mail::send('emails.pqrs', $data, function($message) use ($data) {
                $message->to('tomas.esquivel1508@gmail.com')
                        ->subject('Nuevo PQRS - ' . $data['tipo'])
                        ->replyTo($data['email'], $data['nombre']);
            });

            return response()->json([
                'success' => true,
                'message' => 'PQRS enviado correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el PQRS. Inténtalo de nuevo.',
            ], 500);
        }
    }
} 