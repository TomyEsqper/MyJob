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
@if (
$errors->any())
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
    <script>
    if (typeof closeNotification !== 'function' && typeof window.closeNotification !== 'function') {
        window.closeNotification = function(id) {
            var el = document.getElementById(id);
            if (el) el.style.display = 'none';
        }
    }
    </script>
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
                    <img id="previewFotoPerfil" src="{{ asset('images/default-user.png') }}" alt="Foto de Perfil" class="animated-avatar">
                @endif
                <div class="avatar-overlay">
                    <form action="{{ route('empleado.actualizar-foto') }}" method="POST" enctype="multipart/form-data" id="fotoPerfilForm">
                        @csrf
                        <button type="button" class="avatar-edit-btn" title="Cambiar foto de perfil" onclick="document.getElementById('foto_perfil_upload').click();">
                            <i class="fas fa-camera"></i>
                        </button>
                        <input type="file" name="foto_perfil" id="foto_perfil_upload" accept=".jpg,.jpeg,.png" hidden onchange="this.form.submit()">
                    </form>
                </div>
            </div>
        </div>
        <div class="profile-info fade-in-up delay-1">
            <h1 class="profile-name">{{ $empleado->nombre_usuario }}</h1>
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

@endsection

@section('scripts')
<script src="{{ asset('js/profile-forms.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animación de conteo para stats
    animateCount('stat-exp', {{ $empleado->experiencias->count() }});
    animateCount('stat-edu', {{ $empleado->educaciones->count() }});
    animateCount('stat-cert', {{ $empleado->certificados->count() }});
    animateCount('stat-idioma', {{ $empleado->idiomas->count() }});

    // Preview de foto
    const fotoInput = document.getElementById('foto_perfil_upload');
    const previewFoto = document.getElementById('previewFotoPerfil');
    if (fotoInput && previewFoto) {
        fotoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewFoto.src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    // Manejo del formulario "Sobre Mí" con feedback visual
    const perfilForm = document.getElementById('perfilForm');
    if (perfilForm) {
        perfilForm.addEventListener('submit', function(e) {
            showSaveIndicator();
            
            // Validación básica en frontend
            const nombre = document.getElementById('nombre_usuario').value.trim();
            const profesion = document.getElementById('profesion').value.trim();
            
            if (!nombre) {
                e.preventDefault();
                hideSaveIndicator();
                showNotification('error', 'El nombre completo es obligatorio', 'Campo Requerido');
                document.getElementById('nombre_usuario').focus();
                return false;
            }
            
            if (!profesion) {
                e.preventDefault();
                hideSaveIndicator();
                showNotification('warning', 'La profesión es importante para tu perfil', 'Campo Recomendado');
                document.getElementById('profesion').focus();
                return false;
            }
            
            // Si todo está bien, el formulario se envía normalmente
            setTimeout(() => {
                hideSaveIndicator();
            }, 1000);
        });
    }

    // Manejo del botón de agregar habilidad
    const btnAgregarHabilidad = document.getElementById('btnAgregarHabilidad');
    if (btnAgregarHabilidad) {
        btnAgregarHabilidad.addEventListener('click', function() {
            if (typeof mostrarFormularioHabilidades === 'function') {
                mostrarFormularioHabilidades();
            } else {
                showNotification('info', 'Haz clic en "Agregar Habilidades" para editar tu lista');
            }
        });
    }

    // Refuerzo para asegurar que el submit de habilidades NUNCA sea tradicional
    const habilidadesForm = document.getElementById('habilidadesForm');
    if (habilidadesForm) {
        habilidadesForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // El submit real lo maneja profile-forms.js
            // Si por alguna razón no lo hace, aquí evitamos el submit tradicional
            return false;
        });
    }

    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            let firstError = null;
            form.querySelectorAll('[required]').forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('input-error');
                    if (!firstError) firstError = input;
                } else {
                    input.classList.remove('input-error');
                }
            });
            if (firstError) {
                e.preventDefault();
                showNotification({type: 'error', message: 'Por favor completa todos los campos obligatorios.', title: 'Campos requeridos'});
                firstError.focus();
            }
        });
    });
});
</script>
@endsection
