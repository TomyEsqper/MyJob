<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\OfertaController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\EmpleadorController;
use App\Http\Controllers\DocumentoEmpresaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\NotificacionController;
use App\Models\Usuario;
use App\Models\Oferta;
use App\Models\Empleador;
use Illuminate\Support\Facades\Hash;
// use App\Http\Controllers\Admin\ExportAdminController;
// use App\Http\Controllers\Admin\DashboardController;
// use App\Http\Controllers\Admin\UserController;
// use App\Http\Controllers\Admin\JobController;
// use App\Http\Controllers\Admin\CompanyController;
// use App\Http\Controllers\Admin\ReportController;

// Rutas públicas
Route::get('/', function () {
    return view('index');
});

Route::get('/register', [RegisterController::class, 'showForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/login/google', [LoginController::class, 'googleLogin'])->name('login.google');
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
Route::get('auth/google/redirect', [SocialController::class, 'redirectToGoogle'])->name('google.redirect');
// callback que procesa la respuesta de Google
Route::get('auth/google/callback', [SocialController::class, 'handleGoogleCallback'])->name('google.callback');
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])
    ->name('password.update');

// Rutas para empleado
Route::middleware(['auth'])->group(function () {
    Route::prefix('empleado')->name('empleado.')->group(function () {
        Route::get('/dashboard', function() {
            \Log::info('Usuario autenticado', [
                'user' => auth()->user(),
                'rol' => auth()->user() ? auth()->user()->rol : null
            ]);
            if (!auth()->check() || auth()->user()->rol !== 'empleado') {
                abort(403, 'No tienes permiso para acceder a esta sección.');
            }
            return app(\App\Http\Controllers\EmpleadoController::class)->dashboard();
        })->name('dashboard');
        Route::get('/perfil/{id?}', [EmpleadoController::class, 'perfil'])->name('perfil');
        Route::post('/actualizar-perfil', [EmpleadoController::class, 'actualizarPerfil'])->name('actualizar-perfil');
        Route::post('/actualizar-foto', [EmpleadoController::class, 'actualizarFoto'])->name('actualizar-foto');
        Route::post('/actualizar-cv', [EmpleadoController::class, 'actualizarCV'])->name('actualizar-cv');
        Route::post('/actualizar-habilidades', [EmpleadoController::class, 'actualizarHabilidades'])->name('actualizar-habilidades');
        Route::get('/aplicaciones', [EmpleadoController::class, 'aplicaciones'])->name('aplicaciones');
        Route::post('/aplicaciones/{oferta}', [EmpleadoController::class, 'aplicar'])->name('aplicar');
        Route::get('/ofertas/{oferta}', [EmpleadoController::class, 'verOferta'])->name('ofertas.show');
        Route::get('/buscar', [EmpleadoController::class, 'buscar'])->name('buscar');
        Route::get('/cv', [EmpleadoController::class, 'cv'])->name('cv');
        Route::get('/notificaciones', [EmpleadoController::class, 'notificaciones'])->name('notificaciones');
        Route::get('/configuracion', [EmpleadoController::class, 'configuracion'])->name('configuracion');
        Route::post('/actualizar-contrasena', [EmpleadoController::class, 'actualizarContrasena'])->name('actualizar-contrasena');
        Route::post('/eliminar-cuenta', [EmpleadoController::class, 'eliminarCuenta'])->name('eliminar-cuenta');
        Route::post('/guardar-preferencias', [EmpleadoController::class, 'guardarPreferencias'])->name('guardar-preferencias');
        Route::post('/actualizar-correo', [EmpleadoController::class, 'actualizarCorreo'])->name('actualizar-correo');
        Route::post('/actualizar-privacidad', [EmpleadoController::class, 'actualizarPrivacidad'])->name('actualizar-privacidad');
        Route::post('/cerrar-otras-sesiones', [EmpleadoController::class, 'cerrarOtrasSesiones'])->name('cerrar-otras-sesiones');
        Route::put('/perfil/{id}', [EmpleadoController::class, 'actualizarPerfil'])->name('perfil.update');
        Route::get('/notificaciones-ajax', [EmpleadoController::class, 'notificacionesAjax'])->name('notificaciones.ajax');
        
        // Rutas para experiencia
        Route::post('/perfil/experiencia', [EmpleadoController::class, 'storeExperiencia'])->name('perfil.experiencia.store');
        Route::put('/perfil/experiencia/{id}', [EmpleadoController::class, 'updateExperiencia'])->name('perfil.experiencia.update');
        Route::delete('/perfil/experiencia/{id}', [EmpleadoController::class, 'destroyExperiencia'])->name('perfil.experiencia.destroy');
        
        // Rutas para educación
        Route::post('/perfil/educacion', [EmpleadoController::class, 'storeEducacion'])->name('perfil.educacion.store');
        Route::put('/perfil/educacion/{id}', [EmpleadoController::class, 'updateEducacion'])->name('perfil.educacion.update');
        Route::delete('/perfil/educacion/{id}', [EmpleadoController::class, 'destroyEducacion'])->name('perfil.educacion.destroy');
        
        // Rutas para certificados
        Route::post('/perfil/certificado', [EmpleadoController::class, 'storeCertificado'])->name('perfil.certificado.store');
        Route::put('/perfil/certificado/{id}', [EmpleadoController::class, 'updateCertificado'])->name('perfil.certificado.update');
        Route::delete('/perfil/certificado/{id}', [EmpleadoController::class, 'destroyCertificado'])->name('perfil.certificado.destroy');
        
        // Rutas para idiomas
        Route::post('/perfil/idioma', [EmpleadoController::class, 'storeIdioma'])->name('perfil.idioma.store');
        Route::put('/perfil/idioma/{id}', [EmpleadoController::class, 'updateIdioma'])->name('perfil.idioma.update');
        Route::delete('/perfil/idioma/{id}', [EmpleadoController::class, 'destroyIdioma'])->name('perfil.idioma.destroy');

        Route::get('/agenda', [EmpleadoController::class, 'agendaEntrevistas'])->name('agenda');
        Route::delete('/aplicaciones/{oferta}', [EmpleadoController::class, 'desaplicar'])->name('desaplicar');
    });
});

// Rutas para empleador
Route::middleware(['auth'])->group(function () {
    Route::prefix('empleador')->name('empleador.')->group(function () {
        Route::get('/dashboard', function() {
            if (!auth()->check() || auth()->user()->rol !== 'empleador') {
                abort(403, 'No tienes permiso para acceder a esta sección.');
            }
            return app(\App\Http\Controllers\EmpleadorController::class)->dashboard();
        })->name('dashboard');

        // Rutas de ofertas
        Route::resource('ofertas', OfertaController::class);

        // Rutas de perfil y empresa
        Route::get('/empresa', [EmpleadorController::class, 'empresa'])->name('empresa');
        Route::get('/perfil', [EmpleadorController::class, 'perfil'])->name('perfil');
        Route::post('/actualizar-perfil', [EmpleadorController::class, 'actualizarPerfil'])->name('actualizar-perfil');
        Route::post('/subir-documento', [EmpleadorController::class, 'subirDocumento'])->name('subir-documento');
        Route::delete('/eliminar-documento/{documento}', [EmpleadorController::class, 'eliminarDocumento'])->name('eliminar-documento');
        Route::post('/actualizar-beneficios', [EmpleadorController::class, 'actualizarBeneficios'])->name('actualizar-beneficios');
        Route::post('/actualizar-foto-perfil', [EmpleadorController::class, 'actualizarFotoPerfil'])->name('actualizar-foto-perfil');

        // Rutas de candidatos
        Route::get('/candidatos', [EmpleadorController::class, 'candidatos'])->name('candidatos');
        Route::get('/candidatos/{usuario}', [EmpleadorController::class, 'verCandidato'])->name('candidato.perfil');
        Route::put('/aplicaciones/{aplicacion}', [EmpleadorController::class, 'actualizarAplicacion'])->name('aplicaciones.actualizar');
        Route::post('/aplicaciones/{aplicacion}/entrevista', [EmpleadorController::class, 'agendarEntrevista'])->name('aplicaciones.entrevista');

        // Rutas de configuración
        Route::get('/configuracion', [EmpleadorController::class, 'configuracion'])->name('configuracion');
        Route::post('/actualizar-contrasena', [EmpleadorController::class, 'actualizarContrasena'])->name('actualizar-contrasena');
        Route::post('/eliminar-cuenta', [EmpleadorController::class, 'eliminarCuenta'])->name('eliminar-cuenta');

        Route::get('/agenda', [EmpleadorController::class, 'agendaEntrevistas'])->name('agenda');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::post('/empleado/perfil/campo', [App\Http\Controllers\EmpleadoController::class, 'actualizarCampo'])->name('empleado.perfil.campo');
    Route::delete('/empleado/perfil/campo', [App\Http\Controllers\EmpleadoController::class, 'eliminarCampo'])->name('empleado.perfil.campo.eliminar');
});

// Rutas del panel de administración
// Eliminadas rutas y controladores de admin

// Ruta para dashboard de admin solo para correos predefinidos
Route::middleware(['auth'])->get('/admin/dashboard', function () {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        $usuariosCount = Usuario::whereNotIn('correo_electronico', $allowedEmails)->count();
        $ofertasCount = Oferta::where('estado', 'activa')->count();
        $empresasCount = Empleador::count();
        return view('admin.dashboard', compact('usuariosCount', 'ofertasCount', 'empresasCount'));
    }
    abort(403, 'No autorizado.');
})->name('admin.dashboard');

Route::middleware(['auth'])->get('/admin/usuarios', function (Illuminate\Http\Request $request) {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        $query = \App\Models\Usuario::where('rol', 'empleado');
        
        // Filtro de búsqueda
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function($sub) use ($q) {
                $sub->where('nombre_usuario', 'like', "%$q%")
                    ->orWhere('correo_electronico', 'like', "%$q%")
                    ->orWhere('id_usuario', $q);
            });
        }
        
        // Filtro de estado activo
        if ($request->filled('activo')) {
            $query->where('activo', $request->input('activo'));
        }
        
        // Filtro de verificado
        if ($request->filled('verificado')) {
            $query->where('verificado', $request->input('verificado'));
        }
        
        // Filtro de destacado
        if ($request->filled('destacado')) {
            $query->where('destacado', $request->input('destacado'));
        }
        
        $usuarios = $query->orderByDesc('id_usuario')->paginate(15);
        return view('admin.users.index', compact('usuarios'));
    }
    abort(403, 'No autorizado.');
});

// Ruta para bulk actions de usuarios
Route::middleware(['auth'])->post('/admin/usuarios/bulk-action', function (Illuminate\Http\Request $request) {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        $action = $request->input('action');
        $userIds = $request->input('users', []);
        
        if (empty($userIds)) {
            return response()->json(['success' => false, 'message' => 'No hay usuarios seleccionados']);
        }
        
        $usuarios = \App\Models\Usuario::whereIn('id_usuario', $userIds)->get();
        $count = 0;
        
        foreach ($usuarios as $usuario) {
            switch ($action) {
                case 'activar':
                    $usuario->activo = true;
                    $usuario->save();
                    $count++;
                    break;
                case 'desactivar':
                    $usuario->activo = false;
                    $usuario->save();
                    $count++;
                    break;
                case 'verificar':
                    $usuario->verificado = true;
                    $usuario->save();
                    $count++;
                    break;
                case 'destacar':
                    $usuario->destacado = true;
                    $usuario->save();
                    $count++;
                    break;
                case 'eliminar':
                    $usuario->delete();
                    $count++;
                    break;
            }
        }
        
        $messages = [
            'activar' => "$count usuarios activados correctamente",
            'desactivar' => "$count usuarios desactivados correctamente",
            'verificar' => "$count usuarios verificados correctamente",
            'destacar' => "$count usuarios destacados correctamente",
            'eliminar' => "$count usuarios eliminados correctamente"
        ];
        
        return response()->json([
            'success' => true,
            'message' => $messages[$action] ?? 'Acción completada'
        ]);
    }
    abort(403, 'No autorizado.');
});

// Ruta para vista de ofertas admin
Route::middleware(['auth'])->get('/admin/ofertas', function (Illuminate\Http\Request $request) {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        $query = \App\Models\Oferta::with(['empleador.empleador']);
        
        // Filtros
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function($sub) use ($q) {
                $sub->where('titulo', 'like', "%$q%")
                    ->orWhere('descripcion', 'like', "%$q%")
                    ->orWhere('ubicacion', 'like', "%$q%");
            });
        }
        
        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }
        
        if ($request->filled('tipo_contrato')) {
            $query->where('tipo_contrato', $request->input('tipo_contrato'));
        }
        
        $ofertas = $query->orderByDesc('created_at')->paginate(15);
        $ofertas->appends($request->all());
        
        return view('admin.ofertas.index', compact('ofertas'));
    }
    abort(403, 'No autorizado.');
});

// Ruta para ver detalle de una oferta específica
Route::middleware(['auth'])->get('/admin/ofertas/{oferta}', function ($ofertaId) {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        $oferta = \App\Models\Oferta::with(['empleador.empleador'])->findOrFail($ofertaId);
        return view('admin.ofertas.show', compact('oferta'));
    }
    abort(403, 'No autorizado.');
});

// Ruta para vista de empresas admin
Route::middleware(['auth'])->get('/admin/empresas', function (Illuminate\Http\Request $request) {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        $query = \App\Models\Usuario::where('rol', 'empleador')->with('empleador');
        
        // Filtro de búsqueda
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function($sub) use ($q) {
                $sub->where('nombre_usuario', 'like', "%$q%")
                    ->orWhere('correo_electronico', 'like', "%$q%")
                    ->orWhere('id_usuario', $q);
            });
        }
        
        // Filtro de estado activo
        if ($request->filled('activo')) {
            $query->where('activo', $request->input('activo'));
        }
        
        // Filtro de verificado
        if ($request->filled('verificado')) {
            $query->where('verificado', $request->input('verificado'));
        }
        
        $empresas = $query->orderByDesc('id_usuario')->paginate(15);
        return view('admin.empresas.index', compact('empresas'));
    }
    abort(403, 'No autorizado.');
});

// Ruta para ver perfil completo de una empresa
Route::middleware(['auth'])->get('/admin/empresas/{empresa}/perfil', function ($empresaId) {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        $empleador = \App\Models\Usuario::with(['empleador', 'ofertas'])->findOrFail($empresaId);
        $ofertas = $empleador->ofertas()->orderByDesc('created_at')->get();
        return view('admin.empresas.perfil', compact('empleador', 'ofertas'));
    }
    abort(403, 'No autorizado.');
});

// Ruta para bulk actions de empresas
Route::middleware(['auth'])->post('/admin/empresas/bulk-action', function (Illuminate\Http\Request $request) {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        $action = $request->input('action');
        $empresaIds = $request->input('empresas', []);
        
        if (empty($empresaIds)) {
            return response()->json(['success' => false, 'message' => 'No hay empresas seleccionadas']);
        }
        
        $empresas = \App\Models\Usuario::whereIn('id_usuario', $empresaIds)->get();
        $count = 0;
        
        foreach ($empresas as $empresa) {
            switch ($action) {
                case 'activar':
                    $empresa->activo = true;
                    $empresa->save();
                    $count++;
                    break;
                case 'desactivar':
                    $empresa->activo = false;
                    $empresa->save();
                    $count++;
                    break;
                case 'verificar':
                    $empresa->verificado = true;
                    $empresa->save();
                    $count++;
                    break;
                case 'eliminar':
                    $empresa->delete();
                    $count++;
                    break;
            }
        }
        
        $messages = [
            'activar' => "$count empresas activadas correctamente",
            'desactivar' => "$count empresas desactivadas correctamente",
            'verificar' => "$count empresas verificadas correctamente",
            'eliminar' => "$count empresas eliminadas correctamente"
        ];
        
        return response()->json([
            'success' => true,
            'message' => $messages[$action] ?? 'Acción completada'
        ]);
    }
    abort(403, 'No autorizado.');
});

// Acciones AJAX para usuarios admin
Route::middleware(['auth'])->post('/admin/usuarios/{usuario}/eliminar', function ($usuarioId) {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        $usuario = \App\Models\Usuario::findOrFail($usuarioId);
        $usuario->delete();
        return response()->json(['success' => true]);
    }
    abort(403, 'No autorizado.');
});
Route::middleware(['auth'])->post('/admin/usuarios/{usuario}/verificar', function ($usuarioId) {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        $usuario = \App\Models\Usuario::findOrFail($usuarioId);
        $usuario->verificado = !$usuario->verificado;
        $usuario->save();
        return response()->json(['success' => true, 'verificado' => $usuario->verificado]);
    }
    abort(403, 'No autorizado.');
});
Route::middleware(['auth'])->post('/admin/usuarios/{usuario}/destacar', function ($usuarioId) {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        $usuario = \App\Models\Usuario::findOrFail($usuarioId);
        $usuario->destacado = !$usuario->destacado;
        $usuario->save();
        return response()->json(['success' => true, 'destacado' => $usuario->destacado]);
    }
    abort(403, 'No autorizado.');
});

Route::middleware(['auth'])->post('/admin/empresas/{empresa}/eliminar', function ($empresaId) {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        $empresa = \App\Models\Usuario::findOrFail($empresaId);
        $empresa->delete();
        return response()->json(['success' => true]);
    }
    abort(403, 'No autorizado.');
});

Route::middleware(['auth'])->post('/admin/empresas/{empresa}/verificar', function ($empresaId) {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        $empresa = \App\Models\Usuario::findOrFail($empresaId);
        $empresa->verificado = !$empresa->verificado;
        $empresa->save();
        return response()->json(['success' => true, 'verificado' => $empresa->verificado]);
    }
    abort(403, 'No autorizado.');
});

// Ruta para cambiar estado de empresa desde perfil
Route::middleware(['auth'])->post('/admin/empresas/{empresa}/cambiar-estado', function ($empresaId) {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        $empresa = \App\Models\Usuario::findOrFail($empresaId);
        $empresa->activo = !$empresa->activo;
        $empresa->save();
        return response()->json(['success' => true, 'activo' => $empresa->activo]);
    }
    abort(403, 'No autorizado.');
});

// Acciones AJAX para ofertas admin
Route::middleware(['auth'])->post('/admin/ofertas/{oferta}/eliminar', function ($ofertaId) {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        $oferta = \App\Models\Oferta::findOrFail($ofertaId);
        $oferta->delete();
        return response()->json(['success' => true]);
    }
    abort(403, 'No autorizado.');
});

Route::middleware(['auth'])->post('/admin/ofertas/{oferta}/cambiar-estado', function ($ofertaId) {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        $oferta = \App\Models\Oferta::findOrFail($ofertaId);
        $oferta->estado = $oferta->estado == 'activa' ? 'inactiva' : 'activa';
        $oferta->save();
        return response()->json(['success' => true, 'estado' => $oferta->estado]);
    }
    abort(403, 'No autorizado.');
});

// Ruta para vista de reportes admin
Route::middleware(['auth'])->get('/admin/reportes', function () {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        // Totales
        $usuariosCount = \App\Models\Usuario::where('rol', 'empleado')->count();
        $empresasCount = \App\Models\Usuario::where('rol', 'empleador')->count();
        $ofertasCount = \App\Models\Oferta::count();
        $aplicacionesCount = \App\Models\Aplicacion::count();
        $usuariosActivos = \App\Models\Usuario::where('rol', 'empleado')->where('activo', 1)->count();
        $usuariosInactivos = \App\Models\Usuario::where('rol', 'empleado')->where('activo', 0)->count();
        $empresasVerificadas = \App\Models\Usuario::where('rol', 'empleador')->where('verificado', 1)->count();
        $empresasNoVerificadas = \App\Models\Usuario::where('rol', 'empleador')->where('verificado', 0)->count();
        $ofertasActivas = \App\Models\Oferta::where('estado', 'activa')->count();
        $ofertasInactivas = \App\Models\Oferta::where('estado', 'inactiva')->count();

        // Evolución mensual (últimos 12 meses)
        $meses = collect(range(0, 11))->map(function($i) {
            return now()->subMonths($i)->format('Y-m');
        })->reverse()->values();
        $usuariosPorMes = $meses->mapWithKeys(function($mes) {
            return [$mes => \App\Models\Usuario::where('rol', 'empleado')->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$mes])->count()];
        });
        $empresasPorMes = $meses->mapWithKeys(function($mes) {
            return [$mes => \App\Models\Usuario::where('rol', 'empleador')->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$mes])->count()];
        });
        $ofertasPorMes = $meses->mapWithKeys(function($mes) {
            return [$mes => \App\Models\Oferta::whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$mes])->count()];
        });
        $aplicacionesPorMes = $meses->mapWithKeys(function($mes) {
            return [$mes => \App\Models\Aplicacion::whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$mes])->count()];
        });

        // Rankings
        $topUsuarios = \App\Models\Usuario::where('rol', 'empleado')->orderByDesc('destacado')->orderByDesc('verificado')->take(5)->get();
        $topEmpresas = \App\Models\Usuario::where('rol', 'empleador')->orderByDesc('verificado')->take(5)->get();
        $topOfertas = \App\Models\Oferta::withCount('aplicaciones')->orderByDesc('aplicaciones_count')->take(5)->get();

        return view('admin.reportes.index', compact(
            'usuariosCount', 'empresasCount', 'ofertasCount', 'aplicacionesCount',
            'usuariosActivos', 'usuariosInactivos', 'empresasVerificadas', 'empresasNoVerificadas',
            'ofertasActivas', 'ofertasInactivas',
            'meses', 'usuariosPorMes', 'empresasPorMes', 'ofertasPorMes', 'aplicacionesPorMes',
            'topUsuarios', 'topEmpresas', 'topOfertas'
        ));
    }
    abort(403, 'No autorizado.');
});

// Ruta para vista de configuración del admin
Route::middleware(['auth'])->get('/admin/configuracion', function () {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        return view('admin.configuracion');
    }
    abort(403, 'No autorizado.');
})->name('admin.configuracion');

// Rutas para actualizar configuración del admin
Route::middleware(['auth'])->post('/admin/configuracion/cambiar-contrasena', function (Illuminate\Http\Request $request) {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
        if (!Hash::check($request->input('current_password'), $user->contrasena)) {
            return redirect()->back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }
        $user->contrasena = Hash::make($request->input('new_password'));
        $user->save();
        return redirect()->back()->with('success', 'Contraseña actualizada correctamente.');
    }
    abort(403, 'No autorizado.');
});

// Rutas para documentos de empresa
Route::middleware(['auth', 'role:empleador'])->group(function () {
    Route::get('/empleador/documentos', [DocumentoEmpresaController::class, 'index'])->name('empleador.documentos.index');
    Route::post('/empleador/documentos', [DocumentoEmpresaController::class, 'store'])->name('empleador.documentos.store');
    Route::delete('/empleador/documentos/{documento}', [DocumentoEmpresaController::class, 'destroy'])->name('empleador.documentos.destroy');
});

// Ruta para verificación de documentos (solo admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/admin/documentos/{documento}/verificar', [DocumentoEmpresaController::class, 'verificar'])->name('admin.documentos.verificar');
});

// Ruta para ver perfil completo de un usuario
Route::middleware(['auth'])->get('/admin/usuarios/{usuario}/perfil', function ($usuarioId) {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        $usuario = \App\Models\Usuario::findOrFail($usuarioId);
        return view('admin.users.perfil', compact('usuario'));
    }
    abort(403, 'No autorizado.');
});

// Ruta para cambiar estado de usuario desde perfil
Route::middleware(['auth'])->post('/admin/usuarios/{usuario}/cambiar-estado', function ($usuarioId) {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        $usuario = \App\Models\Usuario::findOrFail($usuarioId);
        $usuario->activo = !$usuario->activo;
        $usuario->save();
        return response()->json(['success' => true, 'activo' => $usuario->activo]);
    }
    abort(403, 'No autorizado.');
});

// Ruta para cambiar verificación de usuario desde perfil
Route::middleware(['auth'])->post('/admin/usuarios/{usuario}/verificar', function ($usuarioId) {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        $usuario = \App\Models\Usuario::findOrFail($usuarioId);
        $usuario->verificado = !$usuario->verificado;
        $usuario->save();
        return response()->json(['success' => true, 'verificado' => $usuario->verificado]);
    }
    abort(403, 'No autorizado.');
});

// Ruta para cambiar destacado de usuario desde perfil
Route::middleware(['auth'])->post('/admin/usuarios/{usuario}/destacar', function ($usuarioId) {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        $usuario = \App\Models\Usuario::findOrFail($usuarioId);
        $usuario->destacado = !$usuario->destacado;
        $usuario->save();
        return response()->json(['success' => true, 'destacado' => $usuario->destacado]);
    }
    abort(403, 'No autorizado.');
});

// Ruta para vista de aplicaciones admin
Route::middleware(['auth'])->get('/admin/aplicaciones', function (Illuminate\Http\Request $request) {
    if (!auth()->check() || auth()->user()->rol !== 'admin') {
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
    $allowedEmails = [
        't.esquivel@myjob.com.co',
        's.murillo@myjob.com.co',
        'c.cuervo@myjob.com.co',
        'n.plazas@myjob.com.co',
        's.lozano@myjob.com.co',
    ];
    $user = auth()->user();
    if ($user && in_array(strtolower($user->correo_electronico), $allowedEmails)) {
        $query = \App\Models\Aplicacion::with(['usuario', 'oferta.empleador.empleador']);
        
        // Filtros
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function($sub) use ($q) {
                $sub->whereHas('usuario', function($user) use ($q) {
                    $user->where('nombre_usuario', 'like', "%$q%")
                         ->orWhere('correo_electronico', 'like', "%$q%");
                })->orWhereHas('oferta', function($oferta) use ($q) {
                    $oferta->where('titulo', 'like', "%$q%");
                });
            });
        }
        
        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }
        
        $aplicaciones = $query->orderByDesc('created_at')->paginate(15);
        $aplicaciones->appends($request->all());
        
        return view('admin.aplicaciones.index', compact('aplicaciones'));
    }
    abort(403, 'No autorizado.');
});
