<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SocialController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [RegisterController::class, 'showForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/login/google', [LoginController::class, 'googleLogin'])->name('login.google');

// redirigir a Google
Route::get('auth/google/redirect', [SocialController::class, 'redirectToGoogle'])->name('google.redirect');
// callback que procesa la respuesta de Google
Route::get('auth/google/callback', [SocialController::class, 'handleGoogleCallback'])->name('google.callback');
=======
// Rutas para los dashboards
Route::get('/empleado/dashboard', function () {
    return view('empleado.dashboard');
})->name('empleado.dashboard');

Route::get('/empleador/dashboard', function () {
    return view('empleador.dashboard');
})->name('empleador.dashboard');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');
