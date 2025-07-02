@php
use Illuminate\Support\Facades\Storage;
@endphp

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

<div class="row">
    <!-- Columna de Información -->
    <div class="col-lg-8">
        <form action="{{ route('empleador.actualizar-perfil') }}" method="POST" enctype="multipart/form-data" id="perfilForm">
            @csrf
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

            <!-- Documentos -->
            <div class="card form-section-card mt-4">
                <div class="card-header">
                    Documentos
                </div>
                <div class="card-body">
                    <form action="{{ route('empleador.subir-documento') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                        @csrf
                        <div class="input-group">
                            <input type="file" name="documento" class="form-control" required>
                            <button type="submit" class="btn btn-primary">Subir</button>
                        </div>
                    </form>
                    
                    @if($empleador->documentos && $empleador->documentos->count() > 0)
                        <div class="list-group">
                            @foreach($empleador->documentos as $doc)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ asset($doc->ruta_archivo) }}" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
                                        <i class="fas fa-file-alt me-2"></i>
                                        {{ $doc->nombre_archivo }}
                                    </a>
                                    <form action="{{ route('empleador.eliminar-documento', $doc) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar documento">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No hay documentos subidos</p>
                    @endif
                </div>
            </div>

            <div class="form-actions mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>Actualizar Perfil
                </button>
            </div>
        </form>
    </div>

    <!-- Columna Derecha -->
    <div class="col-lg-4">
        <!-- Tarjeta de Foto de Perfil -->
        <div class="card form-section-card">
            <div class="card-header">
                Foto de Perfil
            </div>
            <div class="card-body">
                <form action="{{ route('empleador.actualizar-foto-perfil') }}" method="POST" enctype="multipart/form-data" id="fotoForm">
                    @csrf
                    <div class="text-center mb-3">
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
                        <img src="{{ $src }}" 
                             alt="Foto de perfil" 
                             class="rounded-circle"
                             id="previewFoto"
                             style="width: 150px; height: 150px; object-fit: cover;">
                        
                        @if(session('error'))
                            <div class="alert alert-danger mt-2">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Selecciona una nueva foto</label>
                        <input type="file" 
                               name="foto" 
                               id="foto" 
                               class="form-control @error('foto') is-invalid @enderror" 
                               accept="image/jpeg,image/png,image/jpg">
                        <small class="text-muted d-block mt-1">Formatos permitidos: JPG, JPEG, PNG. Tamaño máximo: 5MB</small>
                        @error('foto')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
        </div>

        @if(!Auth::user()->google_id)
        <!-- Cambiar Contraseña -->
        <div class="card form-section-card mt-4">
            <div class="card-header">
                <i class="fas fa-key me-2"></i>Cambiar Contraseña
            </div>
            <div class="card-body">
                <form action="{{ route('empleador.actualizar-contrasena') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Contraseña Actual</label>
                        <input type="password" 
                               class="form-control @error('current_password') is-invalid @enderror" 
                               name="current_password" 
                               id="current_password" 
                               required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Nueva Contraseña</label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               name="password" 
                               id="password" 
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                        <input type="password" 
                               class="form-control" 
                               name="password_confirmation" 
                               id="password_confirmation" 
                               required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Actualizar Contraseña
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

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