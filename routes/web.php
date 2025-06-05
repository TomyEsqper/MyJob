<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\OfertaController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\EmpleadorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

Route::post('/check-nit', [App\Http\Controllers\RegisterController::class, 'checkNit'])
       ->name('check.nit');

// Rutas para empleado
Route::middleware(['auth'])->group(function () {
    Route::prefix('empleado')->name('empleado.')->group(function () {
        Route::get('/dashboard', [EmpleadoController::class, 'dashboard'])->name('dashboard');
        Route::get('/perfil', [EmpleadoController::class, 'perfil'])->name('perfil');
        Route::post('/actualizar-perfil', [EmpleadoController::class, 'actualizarPerfil'])->name('actualizar-perfil');
        Route::post('/actualizar-foto', [EmpleadoController::class, 'actualizarFoto'])->name('actualizar-foto');
        Route::post('/actualizar-cv', [EmpleadoController::class, 'actualizarCV'])->name('actualizar-cv');
        Route::post('/actualizar-habilidades', [EmpleadoController::class, 'actualizarHabilidades'])->name('actualizar-habilidades');
        Route::get('/aplicaciones', [EmpleadoController::class, 'aplicaciones'])->name('aplicaciones');
        Route::get('/buscar', [EmpleadoController::class, 'buscar'])->name('buscar');
        Route::get('/cv', [EmpleadoController::class, 'cv'])->name('cv');
        Route::get('/notificaciones', [EmpleadoController::class, 'notificaciones'])->name('notificaciones');
        Route::get('/configuracion', [EmpleadoController::class, 'configuracion'])->name('configuracion');
    });
});

// Rutas para empleador
Route::middleware(['auth'])->group(function () {
    Route::prefix('empleador')->name('empleador.')->group(function () {
        Route::get('/dashboard', [EmpleadorController::class, 'dashboard'])->name('dashboard');
        Route::get('/perfil', [EmpleadorController::class, 'perfil'])->name('perfil');
        Route::post('/actualizar-perfil', [EmpleadorController::class, 'actualizarPerfil'])->name('actualizar-perfil');
        Route::post('/actualizar-logo', [EmpleadorController::class, 'actualizarLogo'])->name('actualizar-logo');
        Route::post('/actualizar-beneficios', [EmpleadorController::class, 'actualizarBeneficios'])->name('actualizar-beneficios');
        Route::get('/ofertas', [EmpleadorController::class, 'ofertas'])->name('ofertas');
        Route::get('/candidatos', [EmpleadorController::class, 'candidatos'])->name('candidatos');
        Route::get('/notificaciones', [EmpleadorController::class, 'notificaciones'])->name('notificaciones');
        Route::get('/configuracion', [EmpleadorController::class, 'configuracion'])->name('configuracion');
    });
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::resource('ofertas', OfertaController::class);
