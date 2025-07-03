@php
use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.empleador')

@section('page-title', 'Perfil del Empleador')
@section('page-description', 'Actualiza la información de tu empresa.')

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger shadow-sm">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row g-4">
    <!-- Columna de Información -->
    <div class="col-lg-8">
        <form action="{{ route('empleador.actualizar-perfil') }}" method="POST" enctype="multipart/form-data" id="perfilForm">
            @csrf
            <!-- Tarjeta de Información de la Empresa -->
            <div class="card form-section-card shadow-sm hover-card">
                <div class="card-header bg-light d-flex align-items-center">
                    <i class="fas fa-building me-2 text-success"></i>
                    <h5 class="mb-0">Información de la Empresa</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="nombre_empresa" class="form-label">Nombre de la Empresa <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-building text-success"></i></span>
                                <input type="text" 
                                       class="form-control @error('nombre_empresa') is-invalid @enderror" 
                                       name="nombre_empresa" 
                                       id="nombre_empresa" 
                                       value="{{ old('nombre_empresa', $empleador->nombre_empresa ?? '') }}" 
                                       required 
                                       maxlength="100">
                            </div>
                            @error('nombre_empresa')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nit" class="form-label">NIT <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-id-card text-success"></i></span>
                                <input type="text" 
                                       class="form-control @error('nit') is-invalid @enderror" 
                                       name="nit" 
                                       id="nit" 
                                       value="{{ old('nit', $empleador->nit ?? '') }}" 
                                       required 
                                       maxlength="20">
                            </div>
                            @error('nit')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="correo_empresarial" class="form-label">Correo Empresarial <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope text-success"></i></span>
                                <input type="email" 
                                       class="form-control @error('correo_empresarial') is-invalid @enderror" 
                                       name="correo_empresarial" 
                                       id="correo_empresarial" 
                                       value="{{ old('correo_empresarial', $empleador->correo_empresarial ?? '') }}" 
                                       required 
                                       maxlength="100">
                            </div>
                            @error('correo_empresarial')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="industria" class="form-label">Industria <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-industry text-success"></i></span>
                                <input type="text" 
                                       class="form-control @error('industria') is-invalid @enderror" 
                                       name="industria" 
                                       id="industria" 
                                       value="{{ old('industria', $empleador->sector ?? '') }}" 
                                       required 
                                       maxlength="50">
                            </div>
                            @error('industria')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="ubicacion" class="form-label">Ubicación <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-map-marker-alt text-success"></i></span>
                                <input type="text" 
                                       class="form-control @error('ubicacion') is-invalid @enderror" 
                                       name="ubicacion" 
                                       id="ubicacion" 
                                       value="{{ old('ubicacion', $empleador->ubicacion ?? '') }}" 
                                       required 
                                       maxlength="100">
                            </div>
                            @error('ubicacion')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-align-left text-success"></i></span>
                                <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                          name="descripcion" 
                                          id="descripcion" 
                                          rows="5" 
                                          maxlength="500">{{ old('descripcion', $empleador->descripcion ?? '') }}</textarea>
                            </div>
                            @error('descripcion')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de Contacto -->
            <div class="card form-section-card shadow-sm hover-card mt-4">
                <div class="card-header bg-light d-flex align-items-center">
                    <i class="fas fa-address-card me-2 text-success"></i>
                    <h5 class="mb-0">Información de Contacto</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="sitio_web" class="form-label">Sitio Web</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-globe text-success"></i></span>
                                <input type="url" 
                                       class="form-control @error('sitio_web') is-invalid @enderror" 
                                       name="sitio_web" 
                                       id="sitio_web" 
                                       value="{{ old('sitio_web', $empleador->sitio_web ?? '') }}" 
                                       placeholder="https://ejemplo.com" 
                                       maxlength="200">
                            </div>
                            @error('sitio_web')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                             <label for="telefono" class="form-label">Teléfono</label>
                             <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone text-success"></i></span>
                                <input type="tel" 
                                        class="form-control @error('telefono') is-invalid @enderror" 
                                        name="telefono" 
                                        id="telefono" 
                                        value="{{ old('telefono', $empleador->telefono_contacto ?? '') }}" 
                                        placeholder="Ej: +34 123 456 789" 
                                        maxlength="20">
                             </div>
                            @error('telefono')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions mt-4 text-end">
                <button type="submit" class="btn btn-success btn-lg shadow-sm">
                    <i class="fas fa-save me-2"></i>Actualizar Perfil
                </button>
            </div>
        </form>

        <!-- Formulario de Documentos -->
        <div class="card form-section-card shadow-sm hover-card mt-4">
            <div class="card-header bg-light d-flex align-items-center">
                <i class="fas fa-file-alt me-2 text-success"></i>
                <h5 class="mb-0">Documentos</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('empleador.subir-documento') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                    @csrf
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-file-upload text-success"></i></span>
                        <input type="file" name="documento" class="form-control">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-upload me-1"></i> Subir
                        </button>
                    </div>
                </form>
                
                @if($empleador->documentos && $empleador->documentos->count() > 0)
                    <div class="list-group mt-4 shadow-sm">
                        @foreach($empleador->documentos as $doc)
                            <div class="list-group-item d-flex justify-content-between align-items-center hover-bg-light">
                                <a href="{{ asset($doc->ruta_archivo) }}" target="_blank" rel="noopener noreferrer" class="text-decoration-none d-flex align-items-center">
                                    <i class="fas fa-file-alt me-2 text-success"></i>
                                    <span>{{ $doc->nombre_archivo }}</span>
                                </a>
                                <form action="{{ route('empleador.eliminar-documento', $doc) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar documento" onclick="return confirm('¿Estás seguro de que deseas eliminar este documento?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-file-upload fa-3x text-success mb-3"></i>
                        <p class="text-muted mb-0">No hay documentos subidos</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Columna Derecha -->
    <div class="col-lg-4">
        <!-- Tarjeta de Foto de Perfil -->
        <div class="card form-section-card shadow-sm hover-card">
            <div class="card-header bg-light d-flex align-items-center">
                <i class="fas fa-user-circle me-2 text-success"></i>
                <h5 class="mb-0">Foto de Perfil</h5>
            </div>
            <div class="card-body text-center">
                <form action="{{ route('empleador.actualizar-foto-perfil') }}" method="POST" enctype="multipart/form-data" id="fotoForm">
                    @csrf
                    <div class="mb-4">
                        @php
                            $user = Auth::user();
                            $foto = $user->foto_perfil;
                            if ($foto) {
                                if (filter_var($foto, FILTER_VALIDATE_URL)) {
                                    $src = $foto;
                                } else {
                                    $src = Storage::url('public/' . $foto);
                                }
                            } else {
                                $src = asset('images/user-default.svg');
                            }
                        @endphp
                        <div class="profile-pic-wrapper mb-3">
                            <img src="{{ $src }}" 
                                 alt="Foto de perfil" 
                                 class="rounded-circle shadow profile-pic"
                                 id="previewFoto"
                                 style="width: 180px; height: 180px; object-fit: cover; border: 4px solid #e6f4ea;">
                        </div>
                        
                        @if(session('error'))
                            <div class="alert alert-danger mt-2">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label fw-bold">Selecciona una nueva foto</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-camera text-success"></i></span>
                            <input type="file" 
                                   name="foto" 
                                   id="foto" 
                                   class="form-control @error('foto') is-invalid @enderror" 
                                   accept="image/jpeg,image/png,image/jpg">
                        </div>
                        <small class="text-muted d-block mt-2"><i class="fas fa-info-circle text-success me-1"></i>Formatos permitidos: JPG, JPEG, PNG. Tamaño máximo: 5MB</small>
                        @error('foto')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.hover-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.hover-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}

.hover-bg-light:hover {
    background-color: var(--accent-color-empleador);
}

.profile-pic-wrapper {
    position: relative;
    display: inline-block;
}

.profile-pic {
    transition: all 0.3s ease;
}

.profile-pic:hover {
    filter: brightness(0.9);
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color-empleador);
    box-shadow: 0 0 0 0.25rem rgba(62, 160, 85, 0.25);
}

.text-success {
    color: var(--primary-color-empleador) !important;
}

.btn-success {
    background-color: var(--primary-color-empleador);
    border-color: var(--primary-color-empleador);
}

.btn-success:hover {
    background-color: var(--secondary-color-empleador);
    border-color: var(--secondary-color-empleador);
}
</style>
@endpush

@push('scripts')
<script>
document.getElementById('foto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Validar tamaño
        if (file.size > 5 * 1024 * 1024) {
            alert('El archivo es demasiado grande. El tamaño máximo permitido es 5MB.');
            this.value = '';
            return;
        }

        // Validar tipo
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!allowedTypes.includes(file.type)) {
            alert('Formato de archivo no permitido. Use JPG, JPEG o PNG.');
            this.value = '';
            return;
        }

        // Mostrar preview
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewFoto = document.getElementById('previewFoto');
            previewFoto.src = e.target.result;
            
            // También actualizar la foto en el header
            const headerFoto = document.querySelector('.dropdown-toggle img');
            if (headerFoto) {
                headerFoto.src = e.target.result;
            }
        }
        reader.readAsDataURL(file);
        
        // Submit del formulario
        document.getElementById('fotoForm').submit();
    }
});

// Actualizar la foto en el header si se subió correctamente
@if(session('foto_url'))
    document.addEventListener('DOMContentLoaded', function() {
        const headerFoto = document.querySelector('.dropdown-toggle img');
        if (headerFoto) {
            headerFoto.src = "{{ session('foto_url') }}";
        }
    });
@endif
</script>
@endpush
