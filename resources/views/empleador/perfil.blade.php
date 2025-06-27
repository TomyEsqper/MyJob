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
            <!-- Tarjeta de Información Legal -->
            <div class="card form-section-card mb-4">
                <div class="card-header">
                    <i class="fas fa-id-card me-2"></i>Información Legal
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nit" class="form-label">NIT *</label>
                            <input type="text" 
                                   class="form-control @error('nit') is-invalid @enderror" 
                                   name="nit" 
                                   id="nit" 
                                   value="{{ old('nit', $empleador->nit ?? '') }}" 
                                   required 
                                   maxlength="20">
                            @error('nit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="correo_empresarial" class="form-label">Correo Empresarial *</label>
                            <input type="email" 
                                   class="form-control @error('correo_empresarial') is-invalid @enderror" 
                                   name="correo_empresarial" 
                                   id="correo_empresarial" 
                                   value="{{ old('correo_empresarial', $empleador->correo_empresarial ?? '') }}" 
                                   required 
                                   maxlength="100">
                            @error('correo_empresarial')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de Información de la Empresa -->
            <div class="card form-section-card">
                <div class="card-header">
                    <i class="fas fa-building me-2"></i>Información de la Empresa
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nombre_empresa" class="form-label">Nombre de la Empresa *</label>
                            <input type="text" 
                                   class="form-control @error('nombre_empresa') is-invalid @enderror" 
                                   name="nombre_empresa" 
                                   id="nombre_empresa" 
                                   value="{{ old('nombre_empresa', $empleador->nombre_empresa ?? '') }}" 
                                   required 
                                   maxlength="100">
                            @error('nombre_empresa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="industria" class="form-label">Industria *</label>
                            <input type="text" 
                                   class="form-control @error('industria') is-invalid @enderror" 
                                   name="industria" 
                                   id="industria" 
                                   value="{{ old('industria', $empleador->sector ?? '') }}" 
                                   required 
                                   maxlength="50">
                            @error('industria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ubicacion" class="form-label">Ubicación *</label>
                            <input type="text" 
                                   class="form-control @error('ubicacion') is-invalid @enderror" 
                                   name="ubicacion" 
                                   id="ubicacion" 
                                   value="{{ old('ubicacion', $empleador->ubicacion ?? '') }}" 
                                   required 
                                   maxlength="100">
                            @error('ubicacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      name="descripcion" 
                                      id="descripcion" 
                                      rows="3" 
                                      maxlength="500">{{ old('descripcion', $empleador->descripcion ?? '') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de Contacto -->
            <div class="card form-section-card mt-4">
                <div class="card-header">
                    <i class="fas fa-phone me-2"></i>Información de Contacto
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sitio_web" class="form-label">Sitio Web</label>
                            <input type="url" 
                                   class="form-control @error('sitio_web') is-invalid @enderror" 
                                   name="sitio_web" 
                                   id="sitio_web" 
                                   value="{{ old('sitio_web', $empleador->sitio_web ?? '') }}" 
                                   placeholder="https://ejemplo.com" 
                                   maxlength="200">
                            @error('sitio_web')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                             <label for="telefono" class="form-label">Teléfono</label>
                             <input type="tel" 
                                    class="form-control @error('telefono') is-invalid @enderror" 
                                    name="telefono" 
                                    id="telefono" 
                                    value="{{ old('telefono', $empleador->telefono_contacto ?? '') }}" 
                                    placeholder="Ej: +34 123 456 789" 
                                    maxlength="20">
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna de Logo -->
        <div class="col-lg-4">
            <div class="card form-section-card">
                <div class="card-header">
                    <i class="fas fa-image me-2"></i>Logo de la Empresa
                </div>
                <div class="card-body text-center">
                    <div class="logo-preview-container mb-3">
                        @if ($empleador && $empleador->logo_empresa && Storage::disk('public')->exists($empleador->logo_empresa))
                            <img src="{{ Storage::disk('public')->url($empleador->logo_empresa) }}" 
                                 alt="Logo actual" 
                                 class="img-fluid rounded-circle preview-image" 
                                 style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="bg-secondary rounded-circle preview-image mx-auto d-flex justify-content-center align-items-center" 
                                 style="width: 150px; height: 150px;">
                                <i class="fas fa-building fa-3x text-white"></i>
                            </div>
                        @endif
                    </div>

                    <div class="logo-upload-container">
                        <label for="logo" class="btn btn-outline-primary mb-2">
                            <i class="fas fa-upload me-2"></i>Seleccionar Logo
                        </label>
                        <input type="file" 
                               class="form-control d-none @error('logo') is-invalid @enderror" 
                               name="logo" 
                               id="logo" 
                               accept="image/jpeg,image/png"
                               onchange="previewImage(this);">
                        
                        <div class="selected-file-name text-muted small mt-2" style="display: none;">
                            Archivo seleccionado: <span></span>
                        </div>
                        
                        <div class="form-text text-start">
                            <small class="d-block mb-1"><i class="fas fa-info-circle me-1"></i>Formatos permitidos: JPG, PNG</small>
                            <small class="d-block mb-1"><i class="fas fa-info-circle me-1"></i>Tamaño máximo: 5MB</small>
                            <small class="d-block"><i class="fas fa-info-circle me-1"></i>Dimensión recomendada: 400x400px</small>
                        </div>

                        @error('logo')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions mt-4">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save me-2"></i>Guardar Cambios
        </button>
    </div>
</form>

<!-- Sección de Documentos Legales -->
<div class="card form-section-card mt-4">
    <div class="card-header">
        <i class="fas fa-file-contract me-2"></i>Documentos Legales
    </div>
    <div class="card-body">
        <div class="documentos-legales">
            <!-- Cámara de Comercio -->
            <div class="documento-item mb-3">
                <div class="documento-content">
                    <div class="documento-info">
                        <div class="documento-header">
                            <i class="fas fa-building documento-icon"></i>
                            <div>
                                <h6 class="mb-1">Cámara de Comercio</h6>
                                <p class="text-muted mb-0 small">Formatos permitidos: PDF (Máx. 10MB)</p>
                            </div>
                        </div>
                    </div>
                    <div class="documento-actions">
                        <div class="input-group">
                            <input type="file" 
                                   class="form-control form-control-sm" 
                                   name="camara_comercio" 
                                   accept=".pdf">
                            <button type="button" class="btn btn-sm btn-success">
                                <i class="fas fa-upload"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RUT -->
            <div class="documento-item mb-3">
                <div class="documento-content">
                    <div class="documento-info">
                        <div class="documento-header">
                            <i class="fas fa-file-invoice documento-icon"></i>
                            <div>
                                <h6 class="mb-1">RUT</h6>
                                <p class="text-muted mb-0 small">Formatos permitidos: PDF (Máx. 10MB)</p>
                            </div>
                        </div>
                    </div>
                    <div class="documento-actions">
                        <div class="input-group">
                            <input type="file" 
                                   class="form-control form-control-sm" 
                                   name="rut" 
                                   accept=".pdf">
                            <button type="button" class="btn btn-sm btn-success">
                                <i class="fas fa-upload"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acta de Constitución -->
            <div class="documento-item mb-3">
                <div class="documento-content">
                    <div class="documento-info">
                        <div class="documento-header">
                            <i class="fas fa-file-signature documento-icon"></i>
                            <div>
                                <h6 class="mb-1">Acta de Constitución</h6>
                                <p class="text-muted mb-0 small">Formatos permitidos: PDF (Máx. 10MB)</p>
                            </div>
                        </div>
                    </div>
                    <div class="documento-actions">
                        <div class="input-group">
                            <input type="file" 
                                   class="form-control form-control-sm" 
                                   name="acta_constitucion" 
                                   accept=".pdf">
                            <button type="button" class="btn btn-sm btn-success">
                                <i class="fas fa-upload"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Otros Documentos -->
            <div class="documento-item">
                <div class="documento-content">
                    <div class="documento-info">
                        <div class="documento-header">
                            <i class="fas fa-folder-plus documento-icon"></i>
                            <div>
                                <h6 class="mb-1">Otros Documentos</h6>
                                <p class="text-muted mb-0 small">Formatos permitidos: PDF (Máx. 10MB)</p>
                            </div>
                        </div>
                    </div>
                    <div class="documento-actions">
                        <div class="input-group">
                            <input type="file" 
                                   class="form-control form-control-sm" 
                                   name="otros_documentos" 
                                   accept=".pdf">
                            <button type="button" class="btn btn-sm btn-success">
                                <i class="fas fa-upload"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.form-section-card {
    border: none;
    box-shadow: 0 0 15px rgba(0,0,0,0.05);
    border-radius: 10px;
    margin-bottom: 1rem;
}

.form-section-card .card-header {
    background-color: #fff;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    padding: 1rem;
    font-weight: 600;
    color: #2d3748;
    border-radius: 10px 10px 0 0;
}

.form-section-card .card-body {
    padding: 1.5rem;
}

.logo-preview-container {
    position: relative;
    display: inline-block;
}

.preview-image {
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.logo-upload-container {
    text-align: center;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
}

.btn-success {
    padding: 0.5rem 1.5rem;
    font-weight: 500;
}

.documento-item {
    background-color: #fff;
    border: 1px solid rgba(0,0,0,0.08);
    border-radius: 10px;
    padding: 1.25rem;
    transition: all 0.3s ease;
    margin-bottom: 1rem;
}

.documento-item:hover {
    border-color: #198754;
    box-shadow: 0 0 0 1px #198754;
}

.documento-content {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

@media (min-width: 576px) {
    .documento-content {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
}

.documento-header {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.documento-icon {
    font-size: 1.5rem;
    color: #198754;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(25, 135, 84, 0.1);
    border-radius: 8px;
    flex-shrink: 0;
}

.documento-info {
    flex: 1;
}

.documento-info h6 {
    color: #2d3748;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.documento-actions {
    flex-shrink: 0;
    width: 100%;
}

@media (min-width: 576px) {
    .documento-actions {
        width: auto;
        min-width: 250px;
    }
}

.documento-actions .input-group {
    flex-wrap: nowrap;
}

.documento-actions .form-control {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    border-color: #dee2e6;
    transition: all 0.2s ease;
}

.documento-actions .form-control:focus {
    border-color: #198754;
    box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
}

.documento-actions .btn-success {
    width: 40px;
    height: 31px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    background-color: #198754;
    border-color: #198754;
}

.documento-actions .btn-success:hover {
    background-color: #157347;
    border-color: #157347;
}

.documento-info i {
    color: #198754;
}

/* Ajustes adicionales para móviles */
@media (max-width: 575.98px) {
    .documento-item {
        padding: 1rem;
    }

    .documento-icon {
        width: 32px;
        height: 32px;
        font-size: 1.25rem;
    }

    .documento-info h6 {
        font-size: 1rem;
    }

    .documento-info p {
        font-size: 0.75rem;
    }

    .documento-actions .input-group {
        margin-top: 0.75rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
function previewImage(input) {
    const container = document.querySelector('.logo-preview-container');
    const fileNameContainer = document.querySelector('.selected-file-name');
    const fileNameSpan = fileNameContainer.querySelector('span');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validar tipo de archivo
        if (!['image/jpeg', 'image/png'].includes(file.type)) {
            alert('Por favor, seleccione una imagen en formato JPG o PNG.');
            input.value = '';
            return;
        }
        
        // Validar tamaño (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('El archivo es demasiado grande. El tamaño máximo permitido es 5MB.');
            input.value = '';
            return;
        }

        const reader = new FileReader();
        
        reader.onload = function(e) {
            let preview = container.querySelector('img');
            if (!preview) {
                preview = document.createElement('img');
                preview.classList.add('img-fluid', 'rounded-circle', 'preview-image');
                preview.style.width = '150px';
                preview.style.height = '150px';
                preview.style.objectFit = 'cover';
                container.innerHTML = '';
                container.appendChild(preview);
            }
            preview.src = e.target.result;
            
            // Mostrar nombre del archivo
            fileNameSpan.textContent = file.name;
            fileNameContainer.style.display = 'block';
        };
        
        reader.readAsDataURL(file);
    } else {
        fileNameContainer.style.display = 'none';
    }
}

document.querySelectorAll('.documento-item button').forEach(button => {
    button.addEventListener('click', async function() {
        const fileInput = this.previousElementSibling;
        const file = fileInput.files[0];
        const tipo = fileInput.name;
        
        if (!file) {
            alert('Por favor, seleccione un archivo primero.');
            return;
        }

        if (file.size > 10 * 1024 * 1024) { // 10MB
            alert('El archivo es demasiado grande. El tamaño máximo permitido es 10MB.');
            fileInput.value = '';
            return;
        }
        
        if (file.type !== 'application/pdf') {
            alert('Por favor, seleccione un archivo PDF.');
            fileInput.value = '';
            return;
        }

        // Mostrar indicador de carga
        const originalContent = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;

        try {
            const formData = new FormData();
            formData.append('documento', file);
            formData.append('tipo', tipo);
            formData.append('_token', '{{ csrf_token() }}');

            const response = await fetch('{{ route("empleador.subir-documento-legal") }}', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                // Mostrar mensaje de éxito
                const successAlert = document.createElement('div');
                successAlert.className = 'alert alert-success alert-dismissible fade show mt-3';
                successAlert.innerHTML = `
                    ${result.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                fileInput.parentElement.parentElement.appendChild(successAlert);
                
                // Limpiar el input
                fileInput.value = '';

                // Eliminar la alerta después de 3 segundos
                setTimeout(() => {
                    successAlert.remove();
                }, 3000);
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            alert(error.message || 'Error al subir el documento. Por favor, intente nuevamente.');
        } finally {
            // Restaurar el botón
            button.innerHTML = originalContent;
            button.disabled = false;
        }
    });
});
</script>
@endpush

@endsection 