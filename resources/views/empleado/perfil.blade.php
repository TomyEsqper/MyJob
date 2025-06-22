@extends('layouts.empleado')

@section('page-title', 'Mi Perfil')
@section('page-description', 'Actualiza tu información personal y profesional.')

@section('content')

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('empleado.perfil.update', $empleado->id) }}" method="POST" enctype="multipart/form-data" id="perfilForm">
    @csrf
    @method('PUT')

    <div class="row">
        <!-- Columna principal de formularios -->
        <div class="col-lg-8">
            <!-- Tarjeta de Información Personal -->
            <div class="card form-section-card">
                <div class="card-header">Información Personal</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label">Nombre *</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" value="{{ old('nombre', $empleado->user->nombre) }}" required maxlength="50">
                            <div class="invalid-feedback" id="nombre-error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="apellidos" class="form-label">Apellidos *</label>
                            <input type="text" class="form-control" name="apellidos" id="apellidos" value="{{ old('apellidos', $empleado->user->apellidos) }}" required maxlength="100">
                            <div class="invalid-feedback" id="apellidos-error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" name="telefono" id="telefono" value="{{ old('telefono', $empleado->telefono) }}" maxlength="20">
                            <div class="invalid-feedback" id="telefono-error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ciudad" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" name="ciudad" id="ciudad" value="{{ old('ciudad', $empleado->ciudad) }}" maxlength="100">
                            <div class="invalid-feedback" id="ciudad-error"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de Experiencia Profesional -->
            <div class="card form-section-card">
                <div class="card-header">Experiencia y Habilidades</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="profesion" class="form-label">Profesión / Titular</label>
                        <input type="text" class="form-control" name="profesion" id="profesion" value="{{ old('profesion', $empleado->profesion) }}" placeholder="Ej: Desarrollador Web Full Stack" maxlength="100">
                        <div class="invalid-feedback" id="profesion-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="resumen_profesional" class="form-label">Resumen Profesional</label>
                        <textarea class="form-control" name="resumen_profesional" id="resumen_profesional" rows="4" maxlength="1000">{{ old('resumen_profesional', $empleado->resumen_profesional) }}</textarea>
                        <div class="invalid-feedback" id="resumen_profesional-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="habilidades" class="form-label">Habilidades (separadas por comas)</label>
                        <input type="text" class="form-control" name="habilidades" id="habilidades" value="{{ old('habilidades', is_array($empleado->habilidades) ? implode(', ', $empleado->habilidades) : $empleado->habilidades) }}" placeholder="Ej: PHP, Laravel, Vue.js, MySQL" maxlength="300">
                        <div class="invalid-feedback" id="habilidades-error"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna lateral para Foto y CV -->
        <div class="col-lg-4">
            <!-- Tarjeta para Foto de Perfil -->
            <div class="card form-section-card">
                <div class="card-header">Foto de Perfil</div>
                <div class="card-body text-center">
                    <form action="{{ route('empleado.actualizar-foto') }}" method="POST" enctype="multipart/form-data" id="fotoPerfilForm">
                        @csrf
                        @if ($empleado->user->foto_perfil)
                            <img src="{{ Str::startsWith($empleado->user->foto_perfil, 'http') ? $empleado->user->foto_perfil : asset('storage/' . $empleado->user->foto_perfil) }}" alt="Foto de Perfil" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="bg-secondary rounded-circle mb-3 d-flex justify-content-center align-items-center" style="width: 150px; height: 150px;">
                                <i class="fas fa-user fa-3x text-white"></i>
                            </div>
                        @endif
                        <label for="foto_perfil" class="form-label">Cambiar Foto</label>
                        <input type="file" class="form-control" name="foto_perfil" id="foto_perfil_upload" accept=".jpg,.jpeg,.png" required>
                        <div class="invalid-feedback" id="foto_perfil_upload-error"></div>
                        <button type="submit" class="btn btn-secondary btn-sm mt-3" id="submitFotoBtn" style="display: none;">
                            <i class="fas fa-camera me-2"></i>Actualizar Foto
                        </button>
                        <div id="uploadSpinner" style="display: none;" class="mt-3">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <span class="ms-2">Actualizando foto...</span>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tarjeta para CV -->
            <div class="card form-section-card">
                <div class="card-header">Currículum Vitae (CV)</div>
                <div class="card-body">
                    <label for="cv" class="form-label">Subir nuevo CV</label>
                    <input type="file" class="form-control" name="cv" id="cv" accept=".pdf,.doc,.docx">
                    <div class="form-text">Formatos permitidos: PDF, DOC, DOCX (máx. 10MB)</div>
                    <div class="invalid-feedback" id="cv-error"></div>
                    @if ($empleado->cv_path)
                    <div class="mt-3">
                        <a href="{{ asset('storage/' . $empleado->cv_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-2"></i>Ver CV Actual
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-2"></i>Actualizar Perfil
        </button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mainForm = document.getElementById('perfilForm');
    const fotoForm = document.getElementById('fotoPerfilForm');
    const inputs = mainForm.querySelectorAll('input:not([type="file"]), textarea');
    
    // Función para mostrar error
    function showError(input, message) {
        input.classList.add('is-invalid');
        const errorDiv = document.getElementById(input.id + '-error');
        if (errorDiv) {
            errorDiv.textContent = message;
        }
    }
    
    // Función para limpiar error
    function clearError(input) {
        input.classList.remove('is-invalid');
        const errorDiv = document.getElementById(input.id + '-error');
        if (errorDiv) {
            errorDiv.textContent = '';
        }
    }
    
    // Validar teléfono (formato básico)
    function isValidPhone(phone) {
        if (!phone) return true; // Opcional
        const phoneRegex = /^[\+]?[0-9\s\-\(\)]{7,20}$/;
        return phoneRegex.test(phone);
    }
    
    // Validar archivo de imagen
    function isValidImageFile(file) {
        if (!file) return true; // Opcional
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        const maxSize = 5 * 1024 * 1024; // 5MB
        
        if (!allowedTypes.includes(file.type)) {
            return false;
        }
        
        if (file.size > maxSize) {
            return false;
        }
        
        return true;
    }
    
    // Validar archivo CV
    function isValidCVFile(file) {
        if (!file) return true; // Opcional
        const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        const maxSize = 10 * 1024 * 1024; // 10MB
        
        if (!allowedTypes.includes(file.type)) {
            return false;
        }
        
        if (file.size > maxSize) {
            return false;
        }
        
        return true;
    }
    
    // Validar campo individual
    function validateField(input) {
        const value = input.value.trim();
        
        // Limpiar error previo
        clearError(input);
        
        // Validar campos requeridos
        if (input.hasAttribute('required') && !value) {
            showError(input, 'Este campo es obligatorio.');
            return false;
        }
        
        // Validar longitud máxima
        if (input.hasAttribute('maxlength') && value.length > parseInt(input.getAttribute('maxlength'))) {
            showError(input, `Máximo ${input.getAttribute('maxlength')} caracteres.`);
            return false;
        }
        
        // Validaciones específicas
        switch (input.id) {
            case 'telefono':
                if (value && !isValidPhone(value)) {
                    showError(input, 'Ingresa un número de teléfono válido.');
                    return false;
                }
                break;
                
            case 'foto_perfil_upload':
                if (input.files.length > 0 && !isValidImageFile(input.files[0])) {
                    const file = input.files[0];
                    if (!['image/jpeg', 'image/jpg', 'image/png'].includes(file.type)) {
                        showError(input, 'Solo se permiten archivos JPG y PNG.');
                    } else if (file.size > 5 * 1024 * 1024) {
                        showError(input, 'La imagen no puede pesar más de 5MB.');
                    }
                    return false;
                }
                break;
                
            case 'cv':
                if (input.files.length > 0 && !isValidCVFile(input.files[0])) {
                    const file = input.files[0];
                    if (!['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'].includes(file.type)) {
                        showError(input, 'Solo se permiten archivos PDF, DOC y DOCX.');
                    } else if (file.size > 10 * 1024 * 1024) {
                        showError(input, 'El archivo no puede ser mayor a 10MB.');
                    }
                    return false;
                }
                break;
        }
        
        return true;
    }
    
    // Event listeners para validación en tiempo real
    inputs.forEach(input => {
        input.addEventListener('blur', () => validateField(input));
        input.addEventListener('input', () => {
            if (input.classList.contains('is-invalid')) {
                validateField(input);
            }
        });
    });
    
    // Validación al enviar el formulario
    mainForm.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Validar todos los campos
        inputs.forEach(input => {
            if (!validateField(input)) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            // Mostrar mensaje de error general
            const firstError = mainForm.querySelector('.is-invalid');
            if (firstError) {
                firstError.focus();
            }
        }
    });

    // Auto-submit para el formulario de la foto de perfil
    const fotoInput = document.getElementById('foto_perfil_upload');
    const submitFotoBtn = document.getElementById('submitFotoBtn');
    const uploadSpinner = document.getElementById('uploadSpinner');

    fotoInput.addEventListener('change', function() {
        // Validar que se seleccionó un archivo
        if (this.files.length > 0) {
            // Mostrar spinner y ocultar botón (aunque ya esté oculto)
            uploadSpinner.style.display = 'block';
            submitFotoBtn.style.display = 'none';

            // Enviar el formulario
            fotoForm.submit();
        }
    });

    // Validación para el formulario de la foto de perfil (se mantiene por si acaso)
    fotoForm.addEventListener('submit', function(e) {
        clearError(fotoInput);
        if (fotoInput.files.length === 0) {
            e.preventDefault();
            showError(fotoInput, 'Por favor, selecciona una imagen.');
            return;
        }
        
        const file = fotoInput.files[0];
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        const maxSize = 5 * 1024 * 1024; // 5MB

        if (!allowedTypes.includes(file.type)) {
            e.preventDefault();
            showError(fotoInput, 'Solo se permiten archivos JPG y PNG.');
            return;
        }

        if (file.size > maxSize) {
            e.preventDefault();
            showError(fotoInput, 'La imagen no puede pesar más de 5MB.');
            // Ocultar spinner si hay error
            uploadSpinner.style.display = 'none';
        }
    });
});
</script>
@endsection 