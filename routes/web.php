<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [RegisterController::class, 'showForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

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
