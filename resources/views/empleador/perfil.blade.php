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

<!-- Documentos -->
<div class="mb-3">
    <label class="form-label">Documentos</label>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <form action="{{ route('empleador.subir-documento') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="input-group">
            <input type="file" name="documento" class="form-control" required>
            <button type="submit" class="btn btn-primary">Subir</button>
        </div>
    </form>
    
    <!-- Lista de documentos subidos -->
    <div class="mt-3">
        <h6>Documentos subidos:</h6>
        @if($empleador->documentos && $empleador->documentos->count() > 0)
            <ul class="list-group">
                @foreach($empleador->documentos as $doc)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $doc->nombre_archivo }}
                        <button type="button" class="btn btn-sm btn-danger">×</button>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-muted">No hay documentos subidos</p>
        @endif
    </div>
</div>

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
                                      rows="5" 
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
                    Información de Contacto
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
                    Logo de la Empresa
                </div>
                <div class="card-body text-center">
                    <div class="logo-preview-container mb-3">
                        @if ($empleador && $empleador->logo_empresa)
                            <img src="{{ asset('storage/' . $empleador->logo_empresa) }}" 
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
                               accept=".jpg,.jpeg,.png"
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
            <i class="fas fa-save me-2"></i>Actualizar Perfil
        </button>
    </div>
</form>

@push('styles')
<style>
.logo-preview-container {
    position: relative;
    display: inline-block;
}

.preview-image {
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.logo-upload-container {
    margin-top: 1rem;
}

.selected-file-name {
    max-width: 200px;
    margin: 0 auto;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
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
        const reader = new FileReader();
        
        reader.onload = function(e) {
            // Actualizar la previsualización
            let preview = container.querySelector('.preview-image');
            if (preview.tagName === 'DIV') {
                // Si es el placeholder, reemplazarlo con una imagen
                const img = document.createElement('img');
                img.className = 'img-fluid rounded-circle preview-image';
                img.style.width = '150px';
                img.style.height = '150px';
                img.style.objectFit = 'cover';
                container.replaceChild(img, preview);
                preview = img;
            }
            preview.src = e.target.result;
            
            // Mostrar el nombre del archivo
            fileNameSpan.textContent = input.files[0].name;
            fileNameContainer.style.display = 'block';
        };
        
        reader.readAsDataURL(input.files[0]);
    } else {
        // Si no hay archivo seleccionado, ocultar el nombre
        fileNameContainer.style.display = 'none';
    }
}

// Validación del tamaño y tipo de archivo antes de la carga
document.getElementById('logo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const maxSize = 5 * 1024 * 1024; // 5MB
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    
    if (file) {
        if (file.size > maxSize) {
            alert('El archivo es demasiado grande. El tamaño máximo permitido es 5MB.');
            this.value = '';
            return;
        }
        
        if (!allowedTypes.includes(file.type)) {
            alert('Tipo de archivo no permitido. Por favor, seleccione una imagen JPG o PNG.');
            this.value = '';
            return;
        }
    }
});
</script>
@endpush

@endsection 