<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminPredefinedMiddleware
{
    /**
     * Lista de correos permitidos para el dashboard de admin.
     */
    private $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user && in_array(strtolower($user->correo_electronico), $this->allowedEmails)) {
            return $next($request);
        }
        abort(403, 'No autorizado.');
    }
} 