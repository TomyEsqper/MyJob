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
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\NotificacionController;

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
        Route::get('/dashboard', [EmpleadoController::class, 'dashboard'])->name('dashboard');
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
    });
});

// Rutas para empleador
Route::middleware(['auth'])->group(function () {
    Route::prefix('empleador')->name('empleador.')->group(function () {
        Route::get('/dashboard', [EmpleadorController::class, 'dashboard'])->name('dashboard');

        // Rutas de ofertas
        Route::resource('ofertas', OfertaController::class);

        // Rutas de perfil y empresa
        Route::get('/empresa', [EmpleadorController::class, 'empresa'])->name('empresa');
        Route::get('/perfil', [EmpleadorController::class, 'perfil'])->name('perfil');
        Route::post('/actualizar-perfil', [EmpleadorController::class, 'actualizarPerfil'])->name('actualizar-perfil');
        Route::post('/actualizar-avatar', [EmpleadorController::class, 'actualizarAvatar'])->name('actualizar-avatar');
        Route::post('/actualizar-logo', [EmpleadorController::class, 'actualizarLogo'])->name('actualizar-logo');
        Route::post('/actualizar-beneficios', [EmpleadorController::class, 'actualizarBeneficios'])->name('actualizar-beneficios');

        // Rutas de candidatos
        Route::get('/candidatos', [EmpleadorController::class, 'candidatos'])->name('candidatos');
        Route::get('/candidatos/{usuario}', [EmpleadorController::class, 'verCandidato'])->name('candidato.perfil');
        Route::put('/aplicaciones/{aplicacion}', [EmpleadorController::class, 'actualizarAplicacion'])->name('aplicaciones.actualizar');

        // Rutas de estadísticas
        Route::get('/estadisticas', [EmpleadorController::class, 'estadisticas'])->name('estadisticas');
        Route::get('/estadisticas/mensuales', [EmpleadorController::class, 'actualizarEstadisticasMensuales'])->name('estadisticas.mensuales');
        Route::get('/estadisticas/top-ofertas', [EmpleadorController::class, 'obtenerTopOfertas'])->name('estadisticas.top-ofertas');
        
        // Rutas de notificaciones
        Route::prefix('notificaciones')->group(function () {
            Route::get('/', [NotificacionController::class, 'index'])->name('notificaciones');
            Route::get('/no-leidas', [NotificacionController::class, 'obtenerNoLeidas'])->name('notificaciones.no-leidas');
            Route::post('/{notificacion}/marcar-leida', [NotificacionController::class, 'marcarComoLeida'])->name('notificaciones.marcar-leida');
            Route::post('/marcar-todas-leidas', [NotificacionController::class, 'marcarTodasComoLeidas'])->name('notificaciones.marcar-todas-leidas');
            Route::delete('/{notificacion}', [NotificacionController::class, 'eliminar'])->name('notificaciones.eliminar');
            Route::delete('/eliminar-todas', [NotificacionController::class, 'eliminarTodas'])->name('notificaciones.eliminar-todas');
        });

        // Rutas de configuración
        Route::get('/configuracion', [EmpleadorController::class, 'configuracion'])->name('configuracion');
    });
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::middleware(['auth', 'role:empleado'])->group(function () {
    Route::post('/empleado/perfil/campo', [App\Http\Controllers\EmpleadoController::class, 'actualizarCampo'])->name('empleado.perfil.campo');
    Route::delete('/empleado/perfil/campo', [App\Http\Controllers\EmpleadoController::class, 'eliminarCampo'])->name('empleado.perfil.campo.eliminar');
});
