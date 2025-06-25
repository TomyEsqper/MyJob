@extends('layouts.admin')

@section('title', 'Editar Usuario')

@section('content')
<div class="container-fluid">
    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-gray-800">Editar Usuario</h1>
            <p class="mb-0">Modifica los datos del usuario</p>
        </div>
        <div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver
            </a>
        </div>
    </div>

    <!-- Formulario -->
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <!-- Información básica -->
                            <div class="col-12">
                                <h5 class="border-bottom pb-2">Información básica</h5>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="nombre_usuario" class="form-label">Nombre de usuario</label>
                                <input type="text" 
                                       class="form-control @error('nombre_usuario') is-invalid @enderror" 
                                       id="nombre_usuario" 
                                       name="nombre_usuario" 
                                       value="{{ old('nombre_usuario', $user->nombre_usuario) }}"
                                       required>
                                @error('nombre_usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="correo_electronico" class="form-label">Correo electrónico</label>
                                <input type="email" 
                                       class="form-control @error('correo_electronico') is-invalid @enderror" 
                                       id="correo_electronico" 
                                       name="correo_electronico" 
                                       value="{{ old('correo_electronico', $user->correo_electronico) }}"
                                       required>
                                @error('correo_electronico')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="rol" class="form-label">Rol</label>
                                <select class="form-select @error('rol') is-invalid @enderror" 
                                        id="rol" 
                                        name="rol" 
                                        required>
                                    <option value="empleado" {{ old('rol', $user->rol) === 'empleado' ? 'selected' : '' }}>Empleado</option>
                                    <option value="empleador" {{ old('rol', $user->rol) === 'empleador' ? 'selected' : '' }}>Empleador</option>
                                    <option value="admin" {{ old('rol', $user->rol) === 'admin' ? 'selected' : '' }}>Administrador</option>
                                </select>
                                @error('rol')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="activo" class="form-label">Estado</label>
                                <select class="form-select @error('activo') is-invalid @enderror" 
                                        id="activo" 
                                        name="activo" 
                                        required>
                                    <option value="1" {{ old('activo', $user->activo) ? 'selected' : '' }}>Activo</option>
                                    <option value="0" {{ old('activo', $user->activo) ? '' : 'selected' }}>Inactivo</option>
                                </select>
                                @error('activo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Información de contacto -->
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mt-4">Información de contacto</h5>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" 
                                       class="form-control @error('telefono') is-invalid @enderror" 
                                       id="telefono" 
                                       name="telefono" 
                                       value="{{ old('telefono', $user->telefono) }}">
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="ubicacion" class="form-label">Ubicación</label>
                                <input type="text" 
                                       class="form-control @error('ubicacion') is-invalid @enderror" 
                                       id="ubicacion" 
                                       name="ubicacion" 
                                       value="{{ old('ubicacion', $user->ubicacion) }}">
                                @error('ubicacion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                          id="descripcion" 
                                          name="descripcion" 
                                          rows="3">{{ old('descripcion', $user->descripcion) }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Foto de perfil -->
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mt-4">Foto de perfil</h5>
                            </div>

                            <div class="col-12">
                                <div class="d-flex align-items-center gap-4">
                                    <img src="{{ $user->foto_perfil ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->nombre_usuario) }}" 
                                         class="rounded-circle" 
                                         width="100" 
                                         height="100"
                                         alt="{{ $user->nombre_usuario }}">
                                    <div>
                                        <input type="file" 
                                               class="form-control @error('foto_perfil') is-invalid @enderror" 
                                               id="foto_perfil" 
                                               name="foto_perfil"
                                               accept="image/*">
                                        @error('foto_perfil')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Formatos permitidos: JPG, PNG. Tamaño máximo: 2MB
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" 
                                            class="btn btn-info text-white"
                                            onclick="resetPassword()">
                                        <i class="fas fa-key me-2"></i>Restablecer contraseña
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Guardar cambios
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Información adicional -->
        <div class="col-12 col-lg-4">
            <!-- Estadísticas -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Estadísticas</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Fecha de registro</span>
                        <span>{{ $user->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Última actualización</span>
                        <span>{{ $user->updated_at->format('d/m/Y') }}</span>
                    </div>
                    @if($user->rol === 'empleador')
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Ofertas publicadas</span>
                        <span>{{ $user->ofertas->count() }}</span>
                    </div>
                    @endif
                    @if($user->rol === 'empleado')
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Aplicaciones enviadas</span>
                        <span>{{ $user->aplicaciones->count() }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actividad reciente -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Actividad reciente</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($user->actividades()->latest()->take(5)->get() as $actividad)
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $actividad->descripcion }}</h6>
                                <small>{{ $actividad->created_at->diffForHumans() }}</small>
                            </div>
                            <small class="text-muted">{{ $actividad->tipo }}</small>
                        </div>
                        @empty
                        <div class="list-group-item text-center py-4">
                            <i class="fas fa-history fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">No hay actividad reciente</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function resetPassword() {
    if (confirm('¿Estás seguro de que deseas restablecer la contraseña de este usuario? Se generará una nueva contraseña aleatoria.')) {
        fetch(`/admin/users/{{ $user->id_usuario }}/reset-password`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`La contraseña ha sido restablecida. Nueva contraseña: ${data.password}`);
            } else {
                alert('Error al restablecer la contraseña');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al restablecer la contraseña');
        });
    }
}
</script>
@endpush
