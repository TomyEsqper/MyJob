@extends('layouts.admin')

@section('title', 'Configuración del Administrador')
@section('page-title', 'Configuración del Administrador')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fa-solid fa-gear me-2"></i>Configuración de Cuenta</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="adminEmail" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="adminEmail" value="{{ auth()->user()->correo_electronico }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="adminName" class="form-label">Nombre de usuario</label>
                        <input type="text" class="form-control" id="adminName" value="{{ auth()->user()->nombre_usuario }}" disabled>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fa-solid fa-key me-2"></i>Cambiar contraseña</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ url('/admin/configuracion/cambiar-contrasena') }}" id="passwordForm">
                        @csrf
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Contraseña actual</label>
                            <input type="password" class="form-control" id="currentPassword" name="current_password" placeholder="Ingresa tu contraseña actual" required>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">Nueva contraseña</label>
                            <input type="password" class="form-control" id="newPassword" name="new_password" placeholder="Nueva contraseña" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirmar nueva contraseña</label>
                            <input type="password" class="form-control" id="confirmPassword" name="new_password_confirmation" placeholder="Repite la nueva contraseña" required>
                        </div>
                        <button type="submit" class="btn btn-success" id="submitBtn">
                            <i class="fa-solid fa-save me-1"></i> Cambiar contraseña
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Mostrar alertas de éxito
@if(session('success'))
    Swal.fire({
        title: '¡Éxito!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonText: '¡Genial!',
        confirmButtonColor: '#10b981'
    });
@endif

// Mostrar errores de validación
@if($errors->any())
    Swal.fire({
        title: '¡Error!',
        text: '{{ $errors->first() }}',
        icon: 'error',
        confirmButtonText: 'Entendido',
        confirmButtonColor: '#dc3545'
    });
@endif

// Manejo del formulario de contraseña
document.addEventListener('DOMContentLoaded', function() {
    const passwordForm = document.getElementById('passwordForm');
    const submitBtn = document.getElementById('submitBtn');
    
    passwordForm.addEventListener('submit', function(e) {
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        
        if (newPassword !== confirmPassword) {
            e.preventDefault();
            Swal.fire({
                title: '¡Error!',
                text: 'Las contraseñas no coinciden',
                icon: 'error',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#dc3545'
            });
            return;
        }
        
        // Mostrar loading
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Procesando...';
        submitBtn.disabled = true;
    });
});
</script>
@endpush 