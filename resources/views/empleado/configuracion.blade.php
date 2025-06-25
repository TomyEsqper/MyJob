@extends('layouts.empleado')

@section('page-title', 'Configuración')
@section('page-description', 'Ajusta tus preferencias y configuración de cuenta.')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="card-empleado mb-4">
    <div class="card-header-empleado">
        <h5 class="mb-0">Seguridad</h5>
    </div>
    <div class="card-body-empleado">
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
        <h5 class="mb-0">Preferencias</h5>
    </div>
    <div class="card-body-empleado">
        <form method="POST" action="{{ route('empleado.guardar-preferencias') }}">
            @csrf
            <div class="mb-3">
                <label for="notificaciones_email" class="form-label">Notificaciones por email</label>
                <select id="notificaciones_email" name="notificaciones_email" class="form-select">
                    <option value="todas" {{ (auth()->user()->notificaciones_email ?? '') == 'todas' ? 'selected' : '' }}>Todas</option>
                    <option value="solo-importantes" {{ (auth()->user()->notificaciones_email ?? '') == 'solo-importantes' ? 'selected' : '' }}>Solo importantes</option>
                    <option value="ninguna" {{ (auth()->user()->notificaciones_email ?? '') == 'ninguna' ? 'selected' : '' }}>Ninguna</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="idioma" class="form-label">Idioma de la plataforma</label>
                <select id="idioma" name="idioma" class="form-select">
                    <option value="es" {{ (auth()->user()->idioma ?? '') == 'es' ? 'selected' : '' }}>Español</option>
                    <option value="en" {{ (auth()->user()->idioma ?? '') == 'en' ? 'selected' : '' }}>Inglés</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="tema" class="form-label">Tema de visualización</label>
                <select id="tema" name="tema" class="form-select">
                    <option value="claro" {{ (auth()->user()->tema ?? '') == 'claro' ? 'selected' : '' }}>Claro</option>
                    <option value="oscuro" {{ (auth()->user()->tema ?? '') == 'oscuro' ? 'selected' : '' }}>Oscuro</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar preferencias</button>
        </form>
    </div>
</div>

<div class="card-empleado mb-4">
    <div class="card-header-empleado">
        <h5 class="mb-0">Actualización de correo electrónico</h5>
    </div>
    <div class="card-body-empleado">
        <form method="POST" action="{{ route('empleado.actualizar-correo') }}">
            @csrf
            <div class="mb-3">
                <label for="correo_electronico" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" value="{{ auth()->user()->correo_electronico }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar correo</button>
        </form>
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

<div class="card-empleado mb-4">
    <div class="card-header-empleado">
        <h5 class="mb-0">Gestión de dispositivos</h5>
    </div>
    <div class="card-body-empleado">
        <form method="POST" action="{{ route('empleado.cerrar-otras-sesiones') }}">
            @csrf
            <div class="mb-3">
                <label for="current_password_sessions" class="form-label">Contraseña actual para cerrar otras sesiones</label>
                <input type="password" class="form-control" id="current_password_sessions" name="current_password" required>
            </div>
            <button type="submit" class="btn btn-outline-secondary">Cerrar todas las sesiones excepto la actual</button>
        </form>
    </div>
</div>
@endsection 