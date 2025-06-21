@extends('layouts.empleador')

@section('page-title', 'Perfil del Empleador')
@section('page-description', 'Actualiza la información de tu empresa.')

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

<form action="{{ route('empleador.actualizar-perfil') }}" method="POST" enctype="multipart/form-data" id="perfilForm">
    @csrf

    <div class="row">
        <!-- Columna de Información -->
        <div class="col-lg-8">
            <!-- Tarjeta de Información de la Empresa -->
            <div class="card form-section-card">
                <div class="card-header">
                    Información de la Empresa
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nombre_empresa" class="form-label">Nombre de la Empresa *</label>
                            <input type="text" class="form-control" name="nombre_empresa" id="nombre_empresa" value="{{ old('nombre_empresa', $empleador->nombre_empresa) }}" required maxlength="100">
                            <div class="invalid-feedback" id="nombre_empresa-error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="industria" class="form-label">Industria *</label>
                            <input type="text" class="form-control" name="industria" id="industria" value="{{ old('industria', $empleador->sector) }}" required maxlength="50">
                            <div class="invalid-feedback" id="industria-error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ubicacion" class="form-label">Ubicación *</label>
                            <input type="text" class="form-control" name="ubicacion" id="ubicacion" value="{{ old('ubicacion', $empleador->ubicacion) }}" required maxlength="100">
                            <div class="invalid-feedback" id="ubicacion-error"></div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" rows="5" maxlength="500">{{ old('descripcion', $empleador->descripcion) }}</textarea>
                            <div class="invalid-feedback" id="descripcion-error"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de Contacto -->
            <div class="card form-section-card">
                <div class="card-header">
                    Información de Contacto
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sitio_web" class="form-label">Sitio Web</label>
                            <input type="url" class="form-control" name="sitio_web" id="sitio_web" value="{{ old('sitio_web', $empleador->sitio_web) }}" placeholder="https://ejemplo.com" maxlength="200">
                            <div class="invalid-feedback" id="sitio_web-error"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                             <label for="telefono" class="form-label">Teléfono</label>
                             <input type="tel" class="form-control" name="telefono" id="telefono" value="{{ old('telefono', $empleador->telefono_contacto) }}" placeholder="Ej: +34 123 456 789" maxlength="20">
                             <div class="invalid-feedback" id="telefono-error"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna de Logo -->
        <div class="col-lg-4">
            <div class="card form-section-card">
                <div class="card-header">
                    Logo de la Empresa
                </div>
                <div class="card-body text-center">
                    @if ($empleador->logo_empresa)
                        <img src="{{ asset('storage/' . $empleador->logo_empresa) }}" alt="Logo actual" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="bg-secondary rounded-circle mb-3 d-flex justify-content-center align-items-center" style="width: 150px; height: 150px;">
                            <i class="fas fa-building fa-3x text-white"></i>
                        </div>
                    @endif
                    <label for="logo" class="form-label">Cambiar Logo</label>
                    <input type="file" class="form-control" name="logo" id="logo" accept=".jpg,.jpeg,.png">
                    <div class="form-text">Sube el logo de tu empresa (formato: .jpg, .png).</div>
                    <div class="invalid-feedback" id="logo-error"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save me-2"></i>Actualizar Perfil
        </button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('perfilForm');
    const inputs = form.querySelectorAll('input, textarea');
    
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
    
    // Validar URL
    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }
    
    // Validar teléfono (formato básico)
    function isValidPhone(phone) {
        if (!phone) return true; // Opcional
        const phoneRegex = /^[\+]?[0-9\s\-\(\)]{7,20}$/;
        return phoneRegex.test(phone);
    }
    
    // Validar archivo
    function isValidFile(file) {
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
            case 'sitio_web':
                if (value && !isValidUrl(value)) {
                    showError(input, 'Ingresa una URL válida (ej: https://ejemplo.com).');
                    return false;
                }
                break;
                
            case 'telefono':
                if (value && !isValidPhone(value)) {
                    showError(input, 'Ingresa un número de teléfono válido.');
                    return false;
                }
                break;
                
            case 'logo':
                if (input.files.length > 0 && !isValidFile(input.files[0])) {
                    const file = input.files[0];
                    if (!['image/jpeg', 'image/jpg', 'image/png'].includes(file.type)) {
                        showError(input, 'Solo se permiten archivos JPG y PNG.');
                    } else if (file.size > 5 * 1024 * 1024) {
                        showError(input, 'El archivo no puede ser mayor a 5MB.');
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
    form.addEventListener('submit', function(e) {
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
            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                firstError.focus();
            }
        }
    });
});
</script>
@endsection 