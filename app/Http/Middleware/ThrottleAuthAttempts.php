<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter as FacadesRateLimiter;
use Symfony\Component\HttpFoundation\Response;

class ThrottleAuthAttempts
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = $request->ip();

        if (FacadesRateLimiter::tooManyAttempts($key, 5)) { // 5 intentos
            $seconds = FacadesRateLimiter::availableIn($key);
            
            return response()->json([
                'error' => 'Demasiados intentos. Por favor, espera ' . $seconds . ' segundos.'
            ], 429);
        }

        FacadesRateLimiter::hit($key, 300); // 5 minutos de bloqueo

        return $next($request);
    }
} 