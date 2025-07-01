@extends('layouts.admin')

@section('title', 'Detalle de Oferta')

@section('page-title', 'Detalle de Oferta')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Principal -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    <i class="fa-solid fa-briefcase fa-2x text-warning"></i>
                                </div>
                                <div>
                                    <h2 class="text-white mb-1 fw-bold">{{ $oferta->titulo }}</h2>
                                    <p class="text-white-50 mb-0">
                                        <i class="fa-solid fa-building me-2"></i>
                                        {{ $oferta->empleador->empleador->nombre_empresa ?? 'Sin empresa' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-end">
                            <div class="bg-white bg-opacity-10 rounded p-3 d-inline-block">
                                <div class="text-center text-white">
                                    <div class="fs-4 fw-bold">{{ $oferta->created_at->format('d') }}</div>
                                    <div class="text-uppercase">{{ $oferta->created_at->format('M') }}</div>
                                    <div class="small">{{ $oferta->created_at->format('Y') }}</div>
                                    <small class="opacity-75">Publicada</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información Rápida -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fa-solid fa-map-marker-alt fa-2x text-primary mb-2"></i>
                                <h6 class="mb-1">Ubicación</h6>
                                <p class="mb-0 text-muted">{{ $oferta->ubicacion }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fa-solid fa-clock fa-2x text-success mb-2"></i>
                                <h6 class="mb-1">Tipo de Contrato</h6>
                                <p class="mb-0 text-muted">{{ $oferta->tipo_contrato }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fa-solid fa-dollar-sign fa-2x text-warning mb-2"></i>
                                <h6 class="mb-1">Salario</h6>
                                <p class="mb-0 text-muted">COP ${{ number_format($oferta->salario, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fa-solid fa-toggle-on fa-2x text-info mb-2"></i>
                                <h6 class="mb-1">Estado</h6>
                                <span class="badge {{ $oferta->estado == 'activa' ? 'bg-success' : 'bg-secondary' }} fs-6">
                                    {{ ucfirst($oferta->estado) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Columna Principal -->
        <div class="col-lg-8">
            <!-- Descripción -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-file-text me-2"></i>
                        Descripción del Puesto
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="bg-light rounded p-4 border-start border-4 border-primary">
                        {!! nl2br(e($oferta->descripcion)) !!}
                    </div>
                </div>
            </div>

            <!-- Requisitos -->
            @if($oferta->requisitos)
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-list-check me-2"></i>
                        Requisitos
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="bg-light rounded p-4 border-start border-4 border-success">
                        {!! nl2br(e($oferta->requisitos)) !!}
                    </div>
                </div>
            </div>
            @endif

            <!-- Beneficios -->
            @if($oferta->beneficios)
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-gift me-2"></i>
                        Beneficios
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="bg-light rounded p-4 border-start border-4 border-info">
                        {!! nl2br(e($oferta->beneficios)) !!}
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Columna Lateral -->
        <div class="col-lg-4">
            <!-- Información de la Empresa -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-building me-2"></i>
                        Información de la Empresa
                    </h5>
                </div>
                <div class="card-body p-4">
                    <!-- Logo y Nombre -->
                    <div class="text-center mb-4">
                        @if($oferta->empleador->empleador && $oferta->empleador->empleador->logo_empresa)
                            <div class="position-relative d-inline-block">
                                <img src="{{ asset($oferta->empleador->empleador->logo_empresa) }}" 
                                     alt="Logo empresa" 
                                     class="img-fluid rounded-circle shadow" 
                                     style="width: 80px; height: 80px; object-fit: cover;">
                                <div class="position-absolute top-0 end-0 bg-success rounded-circle" style="width: 15px; height: 15px;"></div>
                            </div>
                        @else
                            <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="fa-solid fa-building fa-2x text-white"></i>
                            </div>
                        @endif
                        <h6 class="mt-3 mb-0 fw-bold">{{ $oferta->empleador->empleador->nombre_empresa ?? 'Sin empresa' }}</h6>
                    </div>

                    <!-- Información de Contacto -->
                    <div class="space-y-2">
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-user text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Contacto</small>
                                <strong>{{ $oferta->empleador->nombre_usuario }}</strong>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-envelope text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Email</small>
                                <strong>{{ $oferta->empleador->correo_electronico }}</strong>
                            </div>
                        </div>
                        
                        @if($oferta->empleador->empleador && $oferta->empleador->empleador->telefono)
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-phone text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Teléfono</small>
                                <strong>{{ $oferta->empleador->empleador->telefono }}</strong>
                            </div>
                        </div>
                        @endif
                        
                        @if($oferta->empleador->empleador && $oferta->empleador->empleador->sitio_web)
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-globe text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Sitio web</small>
                                <a href="{{ $oferta->empleador->empleador->sitio_web }}" target="_blank" class="text-decoration-none">
                                    <strong>Visitar sitio</strong>
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Botón para ver perfil completo -->
                    <div class="mt-4">
                        <a href="/admin/empresas/{{ $oferta->empleador->id_usuario }}/perfil" class="btn btn-primary w-100">
                            <i class="fa-solid fa-eye me-2"></i>
                            Ver Perfil Completo
                        </a>
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
                        <button class="btn btn-warning" onclick="cambiarEstado({{ $oferta->id }})">
                            <i class="fa-solid fa-toggle-on me-2"></i>
                            Cambiar Estado
                        </button>
                        <button class="btn btn-danger" onclick="eliminarOferta({{ $oferta->id }})">
                            <i class="fa-solid fa-trash me-2"></i>
                            Eliminar Oferta
                        </button>
                        <a href="/admin/ofertas" class="btn btn-secondary">
                            <i class="fa-solid fa-arrow-left me-2"></i>
                            Volver al Listado
                        </a>
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-chart-bar me-2"></i>
                        Estadísticas
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-center p-3 bg-primary bg-opacity-10 rounded">
                                <div class="fs-4 fw-bold text-primary">{{ $oferta->created_at->diffForHumans() }}</div>
                                <small class="text-muted">Tiempo publicado</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-success bg-opacity-10 rounded">
                                <div class="fs-4 fw-bold text-success">{{ $oferta->estado == 'activa' ? 'Activa' : 'Inactiva' }}</div>
                                <small class="text-muted">Estado actual</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.space-y-2 > * + * {
    margin-top: 0.75rem;
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

.badge {
    transition: all 0.3s ease;
}

.badge:hover {
    transform: scale(1.05);
}

.text-white-50 {
    color: rgba(255, 255, 255, 0.5) !important;
}
</style>
@endsection

@push('scripts')
<script>
function eliminarOferta(ofertaId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/ofertas/${ofertaId}/eliminar`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('¡Eliminado!', 'La oferta ha sido eliminada.', 'success')
                    .then(() => window.location.href = '/admin/ofertas');
                } else {
                    Swal.fire('Error', 'No se pudo eliminar la oferta.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Ocurrió un error al eliminar la oferta.', 'error');
            });
        }
    });
}

function cambiarEstado(ofertaId) {
    fetch(`/admin/ofertas/${ofertaId}/cambiar-estado`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('¡Actualizado!', 'El estado de la oferta ha sido cambiado.', 'success')
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
</script>
@endpush 