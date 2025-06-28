@extends('layouts.admin')

@section('title', 'Perfil de Empresa')

@section('page-title', 'Perfil de Empresa')

@section('content')
<div class="container-fluid px-4">
    <!-- Header del Perfil -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow border-0" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-4">
                                    @if($empleador->empleador && $empleador->empleador->logo_empresa)
                                        <img src="{{ asset($empleador->empleador->logo_empresa) }}" 
                                             alt="Logo empresa" 
                                             class="img-fluid rounded-circle shadow" 
                                             style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                            <i class="fa-solid fa-building fa-2x text-white"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h2 class="text-white mb-1 fw-bold">{{ $empleador->empleador->nombre_empresa ?? 'Sin empresa' }}</h2>
                                    <p class="text-white-50 mb-0">
                                        <i class="fa-solid fa-user me-2"></i>
                                        {{ $empleador->nombre_usuario }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-end">
                            <div class="bg-white bg-opacity-10 rounded p-3 d-inline-block">
                                <div class="text-center text-white">
                                    <div class="fs-4 fw-bold">{{ $empleador->created_at->format('d') }}</div>
                                    <div class="text-uppercase">{{ $empleador->created_at->format('M') }}</div>
                                    <div class="small">{{ $empleador->created_at->format('Y') }}</div>
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
                                <i class="fa-solid fa-briefcase fa-2x text-primary mb-2"></i>
                                <h6 class="mb-1">Total Ofertas</h6>
                                <p class="mb-0 fs-4 fw-bold text-primary">{{ $ofertas->count() }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fa-solid fa-check-circle fa-2x text-success mb-2"></i>
                                <h6 class="mb-1">Ofertas Activas</h6>
                                <p class="mb-0 fs-4 fw-bold text-success">{{ $ofertas->where('estado', 'activa')->count() }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fa-solid fa-toggle-on fa-2x text-info mb-2"></i>
                                <h6 class="mb-1">Estado</h6>
                                <span class="badge {{ $empleador->activo ? 'bg-success' : 'bg-secondary' }} fs-6">
                                    {{ $empleador->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fa-solid fa-shield-check fa-2x text-warning mb-2"></i>
                                <h6 class="mb-1">Verificado</h6>
                                <span class="badge {{ $empleador->verificado ? 'bg-success' : 'bg-warning' }} fs-6">
                                    {{ $empleador->verificado ? 'Sí' : 'No' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Información de la Empresa -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-building me-2"></i>
                        Información Básica
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="space-y-3">
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-building text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Nombre de la Empresa</small>
                                <strong>{{ $empleador->empleador->nombre_empresa ?? 'No especificado' }}</strong>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-user text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Contacto Principal</small>
                                <strong>{{ $empleador->nombre_usuario }}</strong>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-envelope text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Email Personal</small>
                                <strong>{{ $empleador->correo_electronico }}</strong>
                            </div>
                        </div>

                        @if($empleador->empleador && $empleador->empleador->correo_empresarial)
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-envelope-open text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Email Empresarial</small>
                                <strong>{{ $empleador->empleador->correo_empresarial }}</strong>
                            </div>
                        </div>
                        @else
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-envelope-open text-muted"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Email Empresarial</small>
                                <strong class="text-muted">No especificado</strong>
                            </div>
                        </div>
                        @endif

                        @if($empleador->empleador && $empleador->empleador->nit)
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-id-card text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">NIT</small>
                                <strong>{{ $empleador->empleador->nit }}</strong>
                            </div>
                        </div>
                        @else
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-id-card text-muted"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">NIT</small>
                                <strong class="text-muted">No especificado</strong>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-address-book me-2"></i>
                        Información de Contacto
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="space-y-3">
                        @if($empleador->empleador && $empleador->empleador->telefono_contacto)
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-phone text-success"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Teléfono de Contacto</small>
                                <strong>{{ $empleador->empleador->telefono_contacto }}</strong>
                            </div>
                        </div>
                        @else
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-phone text-muted"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Teléfono de Contacto</small>
                                <strong class="text-muted">No especificado</strong>
                            </div>
                        </div>
                        @endif
                        
                        @if($empleador->empleador && $empleador->empleador->sitio_web)
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-globe text-success"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Sitio web</small>
                                <a href="{{ $empleador->empleador->sitio_web }}" target="_blank" class="text-decoration-none">
                                    <strong>Visitar sitio</strong>
                                </a>
                            </div>
                        </div>
                        @else
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-globe text-muted"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Sitio web</small>
                                <strong class="text-muted">No especificado</strong>
                            </div>
                        </div>
                        @endif

                        @if($empleador->empleador && $empleador->empleador->direccion_empresa)
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-map-marker-alt text-success"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Dirección</small>
                                <strong>{{ $empleador->empleador->direccion_empresa }}</strong>
                            </div>
                        </div>
                        @else
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-map-marker-alt text-muted"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Dirección</small>
                                <strong class="text-muted">No especificada</strong>
                            </div>
                        </div>
                        @endif

                        @if($empleador->empleador && $empleador->empleador->ubicacion)
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-location-dot text-success"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Ubicación</small>
                                <strong>{{ $empleador->empleador->ubicacion }}</strong>
                            </div>
                        </div>
                        @else
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-location-dot text-muted"></i>
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

            <!-- Información Empresarial -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-chart-line me-2"></i>
                        Información Empresarial
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="space-y-3">
                        @if($empleador->empleador && $empleador->empleador->sector)
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-industry text-info"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Sector</small>
                                <strong>{{ $empleador->empleador->sector }}</strong>
                            </div>
                        </div>
                        @else
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-industry text-muted"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Sector</small>
                                <strong class="text-muted">No especificado</strong>
                            </div>
                        </div>
                        @endif

                        @if($empleador->empleador && $empleador->empleador->numero_empleados)
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-users text-info"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Número de Empleados</small>
                                <strong>{{ $empleador->empleador->numero_empleados }}</strong>
                            </div>
                        </div>
                        @else
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="me-3">
                                <i class="fa-solid fa-users text-muted"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Número de Empleados</small>
                                <strong class="text-muted">No especificado</strong>
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
                        <button class="btn btn-warning" onclick="cambiarEstado({{ $empleador->id_usuario }})">
                            <i class="fa-solid fa-toggle-on me-2"></i>
                            {{ $empleador->activo ? 'Desactivar' : 'Activar' }} Empresa
                        </button>
                        <button class="btn btn-info" onclick="cambiarVerificacion({{ $empleador->id_usuario }})">
                            <i class="fa-solid fa-shield-check me-2"></i>
                            {{ $empleador->verificado ? 'Desverificar' : 'Verificar' }} Empresa
                        </button>
                        <button class="btn btn-danger" onclick="eliminarEmpresa({{ $empleador->id_usuario }})">
                            <i class="fa-solid fa-trash me-2"></i>
                            Eliminar Empresa
                        </button>
                        <a href="/admin/empresas" class="btn btn-secondary">
                            <i class="fa-solid fa-arrow-left me-2"></i>
                            Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna Principal -->
        <div class="col-lg-8">
            <!-- Descripción -->
            @if($empleador->empleador && $empleador->empleador->descripcion)
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-file-text me-2"></i>
                        Descripción de la Empresa
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="bg-light rounded p-4 border-start border-4 border-primary">
                        {!! nl2br(e($empleador->empleador->descripcion)) !!}
                    </div>
                </div>
            </div>
            @else
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-file-text me-2"></i>
                        Descripción de la Empresa
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="text-center py-4">
                        <i class="fa-solid fa-file-text fa-3x text-muted mb-3 d-block"></i>
                        <h6 class="text-muted">No hay descripción disponible</h6>
                        <p class="text-muted">La empresa aún no ha proporcionado una descripción.</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Misión -->
            @if($empleador->empleador && $empleador->empleador->mision)
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-bullseye me-2"></i>
                        Misión
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="bg-light rounded p-4 border-start border-4 border-success">
                        {!! nl2br(e($empleador->empleador->mision)) !!}
                    </div>
                </div>
            </div>
            @else
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-bullseye me-2"></i>
                        Misión
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="text-center py-4">
                        <i class="fa-solid fa-bullseye fa-3x text-muted mb-3 d-block"></i>
                        <h6 class="text-muted">No hay misión definida</h6>
                        <p class="text-muted">La empresa aún no ha definido su misión.</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Visión -->
            @if($empleador->empleador && $empleador->empleador->vision)
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-eye me-2"></i>
                        Visión
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="bg-light rounded p-4 border-start border-4 border-info">
                        {!! nl2br(e($empleador->empleador->vision)) !!}
                    </div>
                </div>
            </div>
            @else
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-eye me-2"></i>
                        Visión
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="text-center py-4">
                        <i class="fa-solid fa-eye fa-3x text-muted mb-3 d-block"></i>
                        <h6 class="text-muted">No hay visión definida</h6>
                        <p class="text-muted">La empresa aún no ha definido su visión.</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Beneficios -->
            @if($empleador->empleador && $empleador->empleador->beneficios)
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-gift me-2"></i>
                        Beneficios
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="bg-light rounded p-4 border-start border-4 border-warning">
                        @if(is_array($empleador->empleador->beneficios))
                            <ul class="list-unstyled mb-0">
                                @foreach($empleador->empleador->beneficios as $beneficio)
                                    <li class="mb-2">
                                        <i class="fa-solid fa-check text-success me-2"></i>
                                        {{ $beneficio }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            {!! nl2br(e($empleador->empleador->beneficios)) !!}
                        @endif
                    </div>
                </div>
            </div>
            @else
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-gift me-2"></i>
                        Beneficios
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="text-center py-4">
                        <i class="fa-solid fa-gift fa-3x text-muted mb-3 d-block"></i>
                        <h6 class="text-muted">No hay beneficios definidos</h6>
                        <p class="text-muted">La empresa aún no ha especificado sus beneficios.</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Historial de Ofertas -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-history me-2"></i>
                        Historial de Ofertas
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($ofertas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Título</th>
                                        <th>Ubicación</th>
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ofertas as $oferta)
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $oferta->titulo }}</div>
                                            <small class="text-muted">{{ Str::limit($oferta->descripcion, 50) }}</small>
                                        </td>
                                        <td>{{ $oferta->ubicacion }}</td>
                                        <td>{{ $oferta->tipo_contrato }}</td>
                                        <td>
                                            <span class="badge {{ $oferta->estado == 'activa' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ ucfirst($oferta->estado) }}
                                            </span>
                                        </td>
                                        <td>{{ $oferta->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="/admin/ofertas/{{ $oferta->id }}" class="btn btn-sm btn-info" title="Ver detalles">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fa-solid fa-briefcase fa-3x text-muted mb-3 d-block"></i>
                            <h5 class="text-muted">No hay ofertas publicadas</h5>
                            <p class="text-muted">Esta empresa aún no ha publicado ninguna oferta laboral.</p>
                        </div>
                    @endif
                </div>
            </div>
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
function cambiarEstado(empleadorId) {
    fetch(`/admin/empresas/${empleadorId}/cambiar-estado`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('¡Actualizado!', 'El estado de la empresa ha sido cambiado.', 'success')
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

function cambiarVerificacion(empleadorId) {
    fetch(`/admin/empresas/${empleadorId}/verificar`, {
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

function eliminarEmpresa(empleadorId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción eliminará la empresa y todas sus ofertas. No se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/empresas/${empleadorId}/eliminar`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('¡Eliminado!', 'La empresa ha sido eliminada.', 'success')
                    .then(() => window.location.href = '/admin/empresas');
                } else {
                    Swal.fire('Error', 'No se pudo eliminar la empresa.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Ocurrió un error al eliminar la empresa.', 'error');
            });
        }
    });
}
</script>
@endpush
