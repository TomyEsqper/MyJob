<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\OfertaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\EmpresaController;

Route::get('/', function () {
    return view('index');
});

// 1. GET para mostrar el formulario de registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
    ->name('register.form');
// 2. POST para procesar el registro
Route::post('/register', [RegisterController::class, 'register'])
    ->name('register');
// 3. POST para la verificación de NIT vía AJAX
Route::post('/verificar-nit', [EmpresaController::class, 'verificarNit']);

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

// Rutas para los dashboards
Route::get('/empleado/dashboard', function () {
    return view('empleado.dashboard');
})->name('empleado.dashboard');

Route::get('/empleador/dashboard', [OfertaController::class, 'dashboard'])->name('empleador.dashboard');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');


Route::resource('ofertas', OfertaController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
