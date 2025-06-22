@extends('layouts.empleador')

@section('page-title', '¡Bienvenido de nuevo!')
@section('page-description', 'Aquí tienes un resumen de tu actividad reciente y estadísticas.')

@section('content')
<!-- Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card bg-white rounded shadow-sm p-4">
            <div class="d-flex align-items-center">
                <div class="icon me-3">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="content">
                    <h3 class="mb-1 fw-bold">{{ $totalOfertas }}</h3>
                    <p class="mb-0 text-muted">Ofertas Activas</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card bg-white rounded shadow-sm p-4">
            <div class="d-flex align-items-center">
                <div class="icon me-3">
                    <i class="fas fa-users"></i>
                </div>
                <div class="content">
                    <h3 class="mb-1 fw-bold">{{ $totalCandidatos }}</h3>
                    <p class="mb-0 text-muted">Candidatos Totales</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card bg-white rounded shadow-sm p-4">
            <div class="d-flex align-items-center">
                <div class="icon me-3">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="content">
                    <h3 class="mb-1 fw-bold">{{ $totalVistas }}</h3>
                    <p class="mb-0 text-muted">Vistas de Ofertas</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card bg-white rounded shadow-sm p-4">
            <div class="d-flex align-items-center">
                <div class="icon me-3">
                    <i class="fas fa-handshake"></i>
                </div>
                <div class="content">
                    <h3 class="mb-1 fw-bold">{{ $totalContrataciones }}</h3>
                    <p class="mb-0 text-muted">Contrataciones</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Sections -->
<div class="row">
    <!-- Recent Applications -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100 border-0 shadow-sm rounded">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold"><i class="fas fa-users me-2 text-primary"></i>Candidatos Recientes</h5>
                <a href="{{ route('empleador.candidatos') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Ver Todos</a>
            </div>
            <div class="card-body p-0">
                @forelse($aplicacionesRecientes as $aplicacion)
                    <div class="user-card d-flex align-items-center p-3 border-bottom">
                        <div class="user-avatar me-3">
                            @if($aplicacion->empleado->foto_perfil)
                                <img src="{{ asset($aplicacion->empleado->foto_perfil) }}" 
                                     class="rounded-circle" width="50" height="50"
                                     style="object-fit: cover;">
                            @else
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                            @endif
                        </div>
                        <div class="user-info flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">{{ $aplicacion->empleado->nombre_usuario }}</h6>
                                <span class="badge bg-{{ $aplicacion->estado === 'pendiente' ? 'warning' : ($aplicacion->estado === 'aceptada' ? 'success' : 'danger') }}">
                                    {{ ucfirst($aplicacion->estado) }}
                                </span>
                            </div>
                            <p class="mb-0 text-muted small">
                                <i class="fas fa-briefcase me-1"></i>
                                {{ $aplicacion->oferta->titulo }}
                            </p>
                            <p class="mb-0 text-muted small">
                                <i class="fas fa-clock me-1"></i>
                                {{ $aplicacion->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="user-actions">
                            <a href="{{ route('empleador.candidato.perfil', $aplicacion->empleado) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No hay candidatos recientes</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Job Offers -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100 border-0 shadow-sm rounded">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold"><i class="fas fa-briefcase me-2 text-success"></i>Ofertas Recientes</h5>
                <a href="{{ route('empleador.ofertas.index') }}" class="btn btn-sm btn-outline-success rounded-pill px-3">Ver Todas</a>
            </div>
            <div class="card-body p-0">
                @forelse($ofertasRecientes as $oferta)
                    <div class="job-card d-flex align-items-center p-3 border-bottom">
                        <div class="job-icon me-3">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px;">
                                <i class="fas fa-briefcase text-success"></i>
                            </div>
                        </div>
                        <div class="job-info flex-grow-1">
                            <h6 class="mb-0">{{ $oferta->titulo }}</h6>
                            <p class="mb-0 text-muted small">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                {{ $oferta->ubicacion }}
                            </p>
                            <p class="mb-0 text-muted small">
                                <i class="fas fa-users me-1"></i>
                                {{ $oferta->aplicaciones_count ?? 0 }} candidatos
                            </p>
                        </div>
                        <div class="job-actions">
                            <a href="{{ route('empleador.ofertas.edit', $oferta) }}" 
                               class="btn btn-sm btn-outline-success">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No hay ofertas recientes</p>
                        <a href="{{ route('empleador.ofertas.create') }}" class="btn btn-success mt-3">
                            <i class="fas fa-plus me-1"></i> Crear Oferta
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold"><i class="fas fa-bolt me-2 text-warning"></i>Acciones Rápidas</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="{{ route('empleador.ofertas.create') }}" class="btn btn-success w-100 p-3">
                            <i class="fas fa-plus fa-2x mb-2"></i>
                            <br>Crear Nueva Oferta
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('empleador.candidatos') }}" class="btn btn-primary w-100 p-3">
                            <i class="fas fa-users fa-2x mb-2"></i>
                            <br>Ver Candidatos
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('empleador.perfil') }}" class="btn btn-warning w-100 p-3">
                            <i class="fas fa-building fa-2x mb-2"></i>
                            <br>Editar Empresa
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#" class="btn btn-info w-100 p-3">
                            <i class="fas fa-chart-line fa-2x mb-2"></i>
                            <br>Ver Estadísticas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

