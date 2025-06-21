@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/password-reset.css') }}">
<div class="container-password-reset">
    <div class="password-reset-card">
        <div class="password-reset-left">
            <img src="{{ asset('images/resetPassword.avif') }}" alt="Reset Password Illustration" class="password-reset-illustration">
        </div>
        <div class="password-reset-right">
            <h2 class="password-reset-title">Restablecer<br>contraseña</h2>
            <form method="POST" action="{{ route('password.update') }}" class="password-reset-form">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="correo_electronico" value="{{ old('correo_electronico', $correo_electronico) }}">
                <div class="password-field mb-2">
                    <div style="display: flex; align-items: center;">
                        <input id="password" type="password" class="password-reset-input @error('password') is-invalid @enderror" name="password" required autofocus placeholder="Nueva contraseña" style="flex:1;">
                        <button type="button" class="toggle-password" data-target="password">Mostrar</button>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <ul class="password-rules mt-2 mb-0 ps-3" style="font-size:0.97rem; color:#888; list-style:disc;">
                        <li class="rule" data-rule="length">Al menos 8 caracteres</li>
                        <li class="rule" data-rule="uppercase">Una mayúscula</li>
                        <li class="rule" data-rule="lowercase">Una minúscula</li>
                        <li class="rule" data-rule="number">Un número</li>
                        <li class="rule" data-rule="special">Un carácter especial</li>
                    </ul>
                </div>
                <div class="mb-3">
                    <input id="password-confirm" type="password" class="password-reset-input" name="password_confirmation" required placeholder="Confirmar contraseña">
                </div>
                <button type="submit" class="password-reset-btn">Restablecer</button>
            </form>
            <a href="{{ route('login') }}" class="password-reset-back">Volver al inicio de sesión</a>
        </div>
    </div>
</div>
<script src="{{ asset('js/password-rules.js') }}"></script>
@endsection 