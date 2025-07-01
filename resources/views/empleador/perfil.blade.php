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
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
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
                        <a href="{{ asset($doc->ruta_archivo) }}" target="_blank" rel="noopener noreferrer">
                            {{ $doc->nombre_archivo }}
                        </a>
                        <form action="{{ route('empleador.eliminar-documento', $doc) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">×</button>
                        </form>
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
            <!-- Foto de Perfil -->
            <div class="card form-section-card">
                <div class="card-header">
                    Foto de Perfil
                </div>
                <div class="card-body text-center">
                    @php
                        $user = Auth::user();
                        $foto = $user->foto_perfil;
                        if ($foto) {
                            $src = filter_var($foto, FILTER_VALIDATE_URL) ? $foto : asset('storage/' . $foto);
                        } else {
                            $src = asset('images/user-default.svg');
                        }
                    @endphp
                    <img id="previewFotoPerfil" src="{{ $src }}" alt="Foto de Perfil" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                    @if($user->google_id)
                        <div class="alert alert-info mt-3">
                            Si tu cuenta está vinculada con Google, solo puedes cambiar tu foto de perfil desde tu cuenta de Google.<br>
                            <small>La imagen se actualizará automáticamente aquí cuando la cambies en Google.</small>
                        </div>
                    @else
                        <form action="{{ route('empleador.actualizar-foto-perfil') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <input type="file" class="form-control" name="foto_perfil" id="foto_perfil" accept=".jpg,.jpeg,.png" onchange="previewFotoPerfil(this);" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar Foto de Perfil</button>
                        </form>
                    @endif
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
function previewFotoPerfil(input) {
    const preview = document.getElementById('previewFotoPerfil');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

@endsection 