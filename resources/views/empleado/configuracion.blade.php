@extends('layouts.empleado')

@section('page-title', 'Configuración')
@section('page-description', 'Ajusta tus preferencias y configuración de cuenta.')

@section('content')
@if (session('success'))
    <x-notification type="success" :message="session('success')" title="¡Éxito!" />
@endif
@if (session('error'))
    <x-notification type="error" :message="session('error')" title="¡Error!" />
@endif
@if (session('warning'))
    <x-notification type="warning" :message="session('warning')" title="¡Atención!" />
@endif
@if ($errors->any())
    <x-notification type="error" :message="$errors->first()" title="Error de validación" />
@endif

<div class="card-empleado mb-4">
    <div class="card-header-empleado">
        <h5 class="mb-0">Seguridad</h5>
    </div>
    <div class="card-body-empleado">
        @if (empty(auth()->user()->google_id))
            <form method="POST" action="{{ route('empleado.actualizar-contrasena') }}">
                @csrf
                <div class="mb-3">
                    <label for="current_password" class="form-label">Contraseña actual</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">Nueva contraseña</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                </div>
                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label">Confirmar nueva contraseña</label>
                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
            </form>
        @else
            <div class="alert alert-info mb-3">
                <strong>Tu cuenta está vinculada a Google.</strong><br>
                No puedes cambiar la contraseña aquí porque tu autenticación depende de Google. Si deseas cambiar tu contraseña, hazlo desde tu cuenta de Google.
            </div>
        @endif
        <hr>
        <form method="POST" action="{{ route('empleado.eliminar-cuenta') }}" onsubmit="return confirm('¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.');">
            @csrf
            <div class="mb-3">
                <label class="form-label text-danger">Eliminar cuenta</label>
                <p class="text-muted">Esta acción es irreversible. Todos tus datos serán eliminados.</p>
                <button type="submit" class="btn btn-outline-danger">Eliminar mi cuenta</button>
            </div>
        </form>
    </div>
</div>

<div class="card-empleado mb-4">
    <div class="card-header-empleado">
        <h5 class="mb-0">Correo electrónico registrado</h5>
    </div>
    <div class="card-body-empleado">
        <div class="mb-3">
            <label for="correo_electronico" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" value="{{ auth()->user()->correo_electronico }}" style="background-color: #e9ecef; color: #6c757d; cursor: not-allowed;" tabindex="-1" readonly onfocus="this.blur()" onmousedown="return false;">
        </div>
    </div>
</div>

<div class="card-empleado mb-4">
    <div class="card-header-empleado">
        <h5 class="mb-0">Privacidad</h5>
    </div>
    <div class="card-body-empleado">
        <form method="POST" action="{{ route('empleado.actualizar-privacidad') }}">
            @csrf
            <div class="mb-3">
                <label for="privacidad_perfil" class="form-label">Visibilidad del perfil</label>
                <select id="privacidad_perfil" name="privacidad_perfil" class="form-select">
                    <option value="publico" {{ (auth()->user()->privacidad_perfil ?? '') == 'publico' ? 'selected' : '' }}>Visible para empleadores</option>
                    <option value="privado" {{ (auth()->user()->privacidad_perfil ?? '') == 'privado' ? 'selected' : '' }}>Solo visible para ofertas aplicadas</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar privacidad</button>
        </form>
    </div>
</div>
@endsection 