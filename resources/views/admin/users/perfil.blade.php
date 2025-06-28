@extends('layouts.admin')

@section('title', 'Perfil de Empleado')

@section('page-title', 'Perfil de Empleado')

@section('content')
<div class="container-fluid px-4">
    <!-- Header del Perfil -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-4">
                                    @if($usuario->foto_perfil)
                                        <img src="{{ asset($usuario->foto_perfil) }}" 
                                             alt="Foto de perfil" 
                                             class="img-fluid rounded-circle shadow" 
                                             style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                            <i class="fa-solid fa-user fa-2x text-white"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h2 class="text-white mb-1 fw-bold">{{ $usuario->nombre_usuario }}</h2>
                                    <p class="text-white-50 mb-0">
                                        <i class="fa-solid fa-envelope me-2"></i>
                                        {{ $usuario->correo_electronico }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-end">
                            <div class="bg-white bg-opacity-10 rounded p-3 d-inline-block">
                                <div class="text-center text-white">
                                    <div class="fs-4 fw-bold">{{ $usuario->created_at->format('d') }}</div>
                                    <div class="text-uppercase">{{ $usuario->created_at->format('M') }}</div>
                                    <div class="small">{{ $usuario->created_at->format('Y') }}</div>
                                    <small class="opacity-75">Registrado</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas Rápidas -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fa-solid fa-file-alt fa-2x text-primary mb-2"></i>
                                <h6 class="mb-1">CV Subido</h6>
                                <span class="badge {{ $usuario->cv ? 'bg-success' : 'bg-secondary' }} fs-6">
                                    {{ $usuario->cv ? 'Sí' : 'No' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fa-solid fa-toggle-on fa-2x text-info mb-2"></i>
                                <h6 class="mb-1">Estado</h6>
                                <span class="badge {{ $usuario->activo ? 'bg-success' : 'bg-secondary' }} fs-6">
                                    {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fa-solid fa-shield-check fa-2x text-warning mb-2"></i>
                                <h6 class="mb-1">Verificado</h6>
                                <span class="badge {{ $usuario->verificado ? 'bg-success' : 'bg-warning' }} fs-6">
                                    {{ $usuario->verificado ? 'Sí' : 'No' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fa-solid fa-star fa-2x text-warning mb-2"></i>
                                <h6 class="mb-1">Destacado</h6>
                                <span class="badge {{ $usuario->destacado ? 'bg-warning' : 'bg-secondary' }} fs-6">
                                    {{ $usuario->destacado ? 'Sí' : 'No' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Información Personal -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-user me-2"></i>
                        Información Personal
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="space-y-3">
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-user text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Nombre Completo</small>
                                <strong>{{ $usuario->nombre_usuario }}</strong>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-envelope text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Email</small>
                                <strong>{{ $usuario->correo_electronico }}</strong>
                            </div>
                        </div>

                        @if($usuario->telefono)
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-phone text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Teléfono</small>
                                <strong>{{ $usuario->telefono }}</strong>
                            </div>
                        </div>
                        @else
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-phone text-muted"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Teléfono</small>
                                <strong class="text-muted">No especificado</strong>
                            </div>
                        </div>
                        @endif

                        @if($usuario->fecha_nacimiento)
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-calendar text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Fecha de Nacimiento</small>
                                <strong>{{ $usuario->fecha_nacimiento->format('d/m/Y') }}</strong>
                            </div>
                        </div>
                        @else
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-calendar text-muted"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Fecha de Nacimiento</small>
                                <strong class="text-muted">No especificada</strong>
                            </div>
                        </div>
                        @endif

                        @if($usuario->genero)
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-venus-mars text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Género</small>
                                <strong>{{ $usuario->genero }}</strong>
                            </div>
                        </div>
                        @else
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-venus-mars text-muted"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Género</small>
                                <strong class="text-muted">No especificado</strong>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Información Profesional -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-briefcase me-2"></i>
                        Información Profesional
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="space-y-3">
                        @if($usuario->profesion)
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-graduation-cap text-success"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Profesión</small>
                                <strong>{{ $usuario->profesion }}</strong>
                            </div>
                        </div>
                        @else
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-graduation-cap text-muted"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Profesión</small>
                                <strong class="text-muted">No especificada</strong>
                            </div>
                        </div>
                        @endif

                        @if($usuario->experiencia)
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-clock text-success"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Experiencia</small>
                                <strong>{{ $usuario->experiencia }}</strong>
                            </div>
                        </div>
                        @else
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-clock text-muted"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Experiencia</small>
                                <strong class="text-muted">No especificada</strong>
                            </div>
                        </div>
                        @endif

                        @if($usuario->educacion)
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-university text-success"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Educación</small>
                                <strong>{{ $usuario->educacion }}</strong>
                            </div>
                        </div>
                        @else
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-university text-muted"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Educación</small>
                                <strong class="text-muted">No especificada</strong>
                            </div>
                        </div>
                        @endif

                        @if($usuario->ubicacion)
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-map-marker-alt text-success"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Ubicación</small>
                                <strong>{{ $usuario->ubicacion }}</strong>
                            </div>
                        </div>
                        @else
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-map-marker-alt text-muted"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Ubicación</small>
                                <strong class="text-muted">No especificada</strong>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Acciones Administrativas -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-tools me-2"></i>
                        Acciones Administrativas
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-3">
                        <button class="btn btn-warning" onclick="cambiarEstado({{ $usuario->id_usuario }})">
                            <i class="fa-solid fa-toggle-on me-2"></i>
                            {{ $usuario->activo ? 'Desactivar' : 'Activar' }} Usuario
                        </button>
                        <button class="btn btn-info" onclick="cambiarVerificacion({{ $usuario->id_usuario }})">
                            <i class="fa-solid fa-shield-check me-2"></i>
                            {{ $usuario->verificado ? 'Desverificar' : 'Verificar' }} Usuario
                        </button>
                        <button class="btn btn-warning" onclick="cambiarDestacado({{ $usuario->id_usuario }})">
                            <i class="fa-solid fa-star me-2"></i>
                            {{ $usuario->destacado ? 'Quitar Destacado' : 'Destacar' }} Usuario
                        </button>
                        <button class="btn btn-danger" onclick="eliminarUsuario({{ $usuario->id_usuario }})">
                            <i class="fa-solid fa-trash me-2"></i>
                            Eliminar Usuario
                        </button>
                        <a href="/admin/usuarios" class="btn btn-secondary">
                            <i class="fa-solid fa-arrow-left me-2"></i>
                            Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna Principal -->
        <div class="col-lg-8">
            <!-- CV -->
            @if($usuario->cv)
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-file-alt me-2"></i>
                        Curriculum Vitae
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="text-center">
                        <i class="fa-solid fa-file-pdf fa-3x text-primary mb-3"></i>
                        <h6>CV Disponible</h6>
                        <p class="text-muted">El usuario ha subido su curriculum vitae.</p>
                        <a href="{{ asset($usuario->cv) }}" target="_blank" class="btn btn-primary">
                            <i class="fa-solid fa-download me-2"></i>
                            Ver CV
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-file-alt me-2"></i>
                        Curriculum Vitae
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="text-center py-4">
                        <i class="fa-solid fa-file-alt fa-3x text-muted mb-3 d-block"></i>
                        <h6 class="text-muted">No hay CV disponible</h6>
                        <p class="text-muted">El usuario aún no ha subido su curriculum vitae.</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Biografía -->
            @if($usuario->biografia)
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-user-edit me-2"></i>
                        Biografía
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="bg-light rounded p-4 border-start border-4 border-success">
                        {!! nl2br(e($usuario->biografia)) !!}
                    </div>
                </div>
            </div>
            @else
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-user-edit me-2"></i>
                        Biografía
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="text-center py-4">
                        <i class="fa-solid fa-user-edit fa-3x text-muted mb-3 d-block"></i>
                        <h6 class="text-muted">No hay biografía disponible</h6>
                        <p class="text-muted">El usuario aún no ha proporcionado su biografía.</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Habilidades -->
            @if($usuario->habilidades)
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-tools me-2"></i>
                        Habilidades
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="bg-light rounded p-4 border-start border-4 border-info">
                        {!! nl2br(e($usuario->habilidades)) !!}
                    </div>
                </div>
            </div>
            @else
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-tools me-2"></i>
                        Habilidades
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="text-center py-4">
                        <i class="fa-solid fa-tools fa-3x text-muted mb-3 d-block"></i>
                        <h6 class="text-muted">No hay habilidades definidas</h6>
                        <p class="text-muted">El usuario aún no ha especificado sus habilidades.</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Información Adicional -->
            @if($usuario->informacion_adicional)
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-info-circle me-2"></i>
                        Información Adicional
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="bg-light rounded p-4 border-start border-4 border-warning">
                        {!! nl2br(e($usuario->informacion_adicional)) !!}
                    </div>
                </div>
            </div>
            @else
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-info-circle me-2"></i>
                        Información Adicional
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="text-center py-4">
                        <i class="fa-solid fa-info-circle fa-3x text-muted mb-3 d-block"></i>
                        <h6 class="text-muted">No hay información adicional</h6>
                        <p class="text-muted">El usuario no ha proporcionado información adicional.</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.space-y-3 > * + * {
    margin-top: 1rem;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.text-white-50 {
    color: rgba(255, 255, 255, 0.5) !important;
}
</style>
@endsection

@push('scripts')
<script>
function cambiarEstado(usuarioId) {
    fetch(`/admin/usuarios/${usuarioId}/cambiar-estado`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('¡Actualizado!', 'El estado del usuario ha sido cambiado.', 'success')
            .then(() => location.reload());
        } else {
            Swal.fire('Error', 'No se pudo cambiar el estado.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Ocurrió un error al cambiar el estado.', 'error');
    });
}

function cambiarVerificacion(usuarioId) {
    fetch(`/admin/usuarios/${usuarioId}/verificar`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('¡Actualizado!', 'El estado de verificación ha sido cambiado.', 'success')
            .then(() => location.reload());
        } else {
            Swal.fire('Error', 'No se pudo cambiar la verificación.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Ocurrió un error al cambiar la verificación.', 'error');
    });
}

function cambiarDestacado(usuarioId) {
    fetch(`/admin/usuarios/${usuarioId}/destacar`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('¡Actualizado!', 'El estado de destacado ha sido cambiado.', 'success')
            .then(() => location.reload());
        } else {
            Swal.fire('Error', 'No se pudo cambiar el destacado.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Ocurrió un error al cambiar el destacado.', 'error');
    });
}

function eliminarUsuario(usuarioId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción eliminará el usuario. No se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/usuarios/${usuarioId}/eliminar`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('¡Eliminado!', 'El usuario ha sido eliminado.', 'success')
                    .then(() => window.location.href = '/admin/usuarios');
                } else {
                    Swal.fire('Error', 'No se pudo eliminar el usuario.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Ocurrió un error al eliminar el usuario.', 'error');
            });
        }
    });
}
</script>
@endpush
