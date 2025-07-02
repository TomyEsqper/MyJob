@extends('layouts.empleado')

@section('page-title', 'Mi Perfil')
@section('page-description', 'Actualiza tu información personal y profesional.')

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

<!-- Sistema de Feedback Mejorado - Imposible de Ignorar -->
<div class="profile-content" style="padding-top:0;padding-bottom:0;">
@if (session('success'))
    <div class="feedback-notification feedback-success" id="successNotification">
        <div class="feedback-content">
            <div class="feedback-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="feedback-message">
                <h4>¡Éxito!</h4>
                <p>{{ session('success') }}</p>
            </div>
            <button type="button" class="feedback-close" onclick="closeNotification('successNotification')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="feedback-progress"></div>
    </div>
@endif

@if (session('error'))
    <div class="feedback-notification feedback-error" id="errorNotification">
        <div class="feedback-content">
            <div class="feedback-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="feedback-message">
                <h4>¡Error!</h4>
                <p>{{ session('error') }}</p>
            </div>
            <button type="button" class="feedback-close" onclick="closeNotification('errorNotification')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="feedback-progress"></div>
    </div>
@endif

@if (session('warning'))
    <div class="feedback-notification feedback-warning" id="warningNotification">
        <div class="feedback-content">
            <div class="feedback-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="feedback-message">
                <h4>¡Atención!</h4>
                <p>{{ session('warning') }}</p>
            </div>
            <button type="button" class="feedback-close" onclick="closeNotification('warningNotification')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="feedback-progress"></div>
    </div>
@endif

@if ($errors->any())
    <div class="feedback-notification feedback-error" id="validationErrors">
        <div class="feedback-content">
            <div class="feedback-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="feedback-message">
                <h4>¡Hay errores en el formulario!</h4>
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="feedback-close" onclick="closeNotification('validationErrors')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="feedback-progress"></div>
    </div>
@endif
</div>

<!-- Indicador de Guardado en Tiempo Real -->
<div class="save-indicator" id="saveIndicator" style="display: none;">
    <div class="save-content">
        <div class="save-spinner">
            <i class="fas fa-spinner fa-spin"></i>
        </div>
        <span>Guardando cambios...</span>
    </div>
</div>

<div class="profile-container">
    <!-- Fondo animado y burbujas -->
    <div class="animated-bg">
        <div class="bubble bubble1"></div>
        <div class="bubble bubble2"></div>
        <div class="bubble bubble3"></div>
        <div class="bubble bubble4"></div>
        <div class="bubble bubble5"></div>
    </div>
    <!-- Hero Section -->
    <div class="profile-hero" style="position:relative;z-index:2;">
        <div class="profile-avatar-section fade-in-up">
            <div class="avatar-container" style="position:relative;">
                @if ($empleado->foto_perfil)
                    <img id="previewFotoPerfil" src="{{ Str::startsWith($empleado->foto_perfil, 'http') ? $empleado->foto_perfil : asset('storage/' . $empleado->foto_perfil) }}" alt="Foto de Perfil" class="animated-avatar">
                @else
                    <img id="previewFotoPerfil" src="{{ asset('images/user-default.svg') }}" alt="Foto de Perfil" class="animated-avatar">
                @endif
                <div class="avatar-overlay">
                    <form action="{{ route('empleado.actualizar-foto') }}" method="POST" enctype="multipart/form-data" id="fotoPerfilForm">
                        @csrf
                        <button type="button" class="avatar-edit-btn" title="Cambiar foto de perfil" onclick="document.getElementById('foto_perfil_upload').click();">
                            <i class="fas fa-camera"></i>
                        </button>
                        <input type="file" name="foto_perfil" id="foto_perfil_upload" accept=".jpg,.jpeg,.png" hidden>
                    </form>
                </div>
                @error('foto_perfil')
                    <div class="invalid-feedback d-block text-center mt-2">
                        {{ $message }}
                    </div>
                @enderror
                @if(session('error'))
                    <div class="alert alert-danger mt-2 text-center">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="profile-info fade-in-up delay-1">
            <h1 class="profile-name">
                {{ $empleado->nombre_usuario }}
                @if($empleado->verificado || $empleado->destacado)
                    <span title="Usuario verificado" style="color:#3b82f6; font-size:1.3em; vertical-align:middle; margin-left:0.3em;"><i class="fa-solid fa-circle-check"></i></span>
                @endif
            </h1>
            <p class="profile-title">{{ $empleado->profesion ?? 'Sin profesión definida' }}</p>
            <p class="profile-bio">{{ $empleado->resumen_profesional ?? 'Agrega un resumen profesional para destacar.' }}</p>
            <div class="profile-stats fade-in-up delay-2">
                <div class="stats-grid">
                    <a href="#experiencia-section" class="stat-item-link">
                        <div class="stat-item">
                            <span class="stat-icon text-white"><i class="fas fa-briefcase"></i></span>
                            <span class="stat-number" id="stat-exp">{{ $empleado->experiencias->count() }}</span>
                            <span class="stat-label">EXPERIENCIAS</span>
                        </div>
                    </a>
                    <a href="#educacion-section" class="stat-item-link">
                        <div class="stat-item">
                            <span class="stat-icon text-white"><i class="fas fa-graduation-cap"></i></span>
                            <span class="stat-number" id="stat-edu">{{ $empleado->educaciones->count() }}</span>
                            <span class="stat-label">EDUCACIÓN</span>
                        </div>
                    </a>
                    <a href="#certificados-section" class="stat-item-link">
                        <div class="stat-item">
                            <span class="stat-icon text-white"><i class="fas fa-certificate"></i></span>
                            <span class="stat-number" id="stat-cert">{{ $empleado->certificados->count() }}</span>
                            <span class="stat-label">CERTIFICADOS</span>
                        </div>
                    </a>
                    <a href="#idiomas-section" class="stat-item-link">
                        <div class="stat-item">
                            <span class="stat-icon text-white"><i class="fas fa-language"></i></span>
                            <span class="stat-number" id="stat-idioma">{{ $empleado->idiomas->count() }}</span>
                            <span class="stat-label">IDIOMAS</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="profile-content">
        <div class="content-grid">
            <!-- Left Column -->
            <div class="left-column">
                <div class="glass-card fade-in-up delay-2">
                    @include('empleado.perfil._about', ['empleado' => $empleado])
                </div>
                <div class="glass-card fade-in-up delay-3">
                    @include('empleado.perfil._contact', ['empleado' => $empleado])
                </div>
                <div class="glass-card fade-in-up delay-3">
                    @include('empleado.perfil._skills', ['empleado' => $empleado])
                </div>
            </div>

            <!-- Right Column -->
            <div class="right-column">
                <div class="glass-card fade-in-up delay-2" id="experiencia-section">
                    @include('empleado.perfil._experiencia', ['empleado' => $empleado])
                </div>
                <div class="glass-card fade-in-up delay-3" id="educacion-section">
                    @include('empleado.perfil._educacion', ['empleado' => $empleado])
                </div>
                <div class="glass-card fade-in-up delay-3" id="certificados-section">
                    @include('empleado.perfil._certificados', ['empleado' => $empleado])
                </div>
                <div class="glass-card fade-in-up delay-3" id="idiomas-section">
                    @include('empleado.perfil._idiomas', ['empleado' => $empleado])
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sección de Configuración de Cuenta -->
<div class="profile-section mt-4">
    <div class="section-header">
        <h2><i class="fas fa-cog"></i> Configuración de Cuenta</h2>
    </div>
    <div class="row">
        @if(!Auth::user()->google_id)
        <!-- Cambiar Contraseña -->
        <div class="col-md-6">
            <div class="card form-section-card">
                <div class="card-header">
                    <i class="fas fa-key me-2"></i>Cambiar Contraseña
                </div>
                <div class="card-body">
                    <form action="{{ route('empleado.actualizar-contrasena') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Contraseña Actual</label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('current_password') is-invalid @enderror" 
                                       name="current_password" 
                                       id="current_password" 
                                       required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva Contraseña</label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" 
                                       id="password" 
                                       required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('password_confirmation') is-invalid @enderror" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Actualizar Contraseña
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const button = input.nextElementSibling;
    const icon = button.querySelector('i');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Validación del formulario
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.needs-validation');
    if (form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    }
});
</script>
<script src="{{ asset('js/profile-forms.js') }}"></script>
@endpush

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@endpush
