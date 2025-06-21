@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/password-reset.css') }}">
<div class="container-password-reset">
    <div class="password-reset-card">
        <div class="password-reset-left">
            <!-- Imagen de ejemplo, reemplázala por la tuya -->
            <img src="{{ asset('images/forgotPassword.jpg') }}" alt="Forgot Password Illustration" class="password-reset-illustration">
        </div>
        <div class="password-reset-right">
            <h2 class="password-reset-title">¿Olvidaste<br>tu contraseña?</h2>
            <form method="POST" action="{{ route('password.email') }}" class="password-reset-form">
                @csrf
                <input id="correo_electronico" type="email" name="correo_electronico" class="password-reset-input @error('correo_electronico') is-invalid @enderror" placeholder="Correo electrónico" value="{{ old('correo_electronico') }}" required autofocus>
                @error('correo_electronico')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <button type="submit" class="password-reset-btn">Restablecer contraseña</button>
            </form>
            @if (session('status'))
                <div class="password-reset-success">{{ session('status') }}</div>
            @endif
            <a href="{{ route('login') }}" class="password-reset-back">Volver al inicio de sesión</a>
        </div>
    </div>
</div>
<script src="{{ asset('js/password-reset.js') }}"></script>
@endsection 