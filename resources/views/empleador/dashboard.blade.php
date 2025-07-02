@extends('layouts.empleador')

@section('title', 'Dashboard Empleador')

@section('content')
<div class="container-fluid">
    <!-- Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card bg-white rounded-3 shadow-sm p-4 border-start border-success border-4">
                <div class="d-flex align-items-center">
                    <div class="icon-wrapper bg-success bg-opacity-10 rounded-3 p-3 me-3">
                        <i class="fas fa-briefcase text-success"></i>
                    </div>
                    <div class="content">
                        <h3 class="mb-1 fw-bold text-dark">{{ $totalOfertas }}</h3>
                        <p class="mb-0 text-muted small">Ofertas Totales</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-white rounded-3 shadow-sm p-4 border-start border-primary border-4">
                <div class="d-flex align-items-center">
                    <div class="icon-wrapper bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                        <i class="fas fa-users text-primary"></i>
                    </div>
                    <div class="content">
                        <h3 class="mb-1 fw-bold text-dark">{{ $totalAplicaciones }}</h3>
                        <p class="mb-0 text-muted small">Aplicaciones</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-white rounded-3 shadow-sm p-4 border-start border-info border-4">
                <div class="d-flex align-items-center">
                    <div class="icon-wrapper bg-info bg-opacity-10 rounded-3 p-3 me-3">
                        <i class="fas fa-check-circle text-info"></i>
                    </div>
                    <div class="content">
                        <h3 class="mb-1 fw-bold text-dark">{{ $ofertasActivas }}</h3>
                        <p class="mb-0 text-muted small">Ofertas Activas</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-white rounded-3 shadow-sm p-4 border-start border-warning border-4">
                <div class="d-flex align-items-center">
                    <div class="icon-wrapper bg-warning bg-opacity-10 rounded-3 p-3 me-3">
                        <i class="fas fa-handshake text-warning"></i>
                    </div>
                    <div class="content">
                        <h3 class="mb-1 fw-bold text-dark">{{ $totalContrataciones }}</h3>
                        <p class="mb-0 text-muted small">Contrataciones</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Sections -->
    <div class="row g-4">
        <!-- Recent Applications -->
        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm rounded-3">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
                    <h5 class="mb-0 fw-semibold text-dark">
                        <i class="fas fa-users me-2 text-primary"></i>Aplicaciones Recientes
                    </h5>
                    <a href="{{ route('empleador.candidatos') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                        Ver Todas
                    </a>
                </div>
                <div class="card-body p-0">
                    @if($aplicacionesRecientes->isEmpty())
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-user-friends fa-3x text-muted"></i>
                            </div>
                            <p class="text-muted mb-0">No hay aplicaciones recientes</p>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($aplicacionesRecientes as $aplicacion)
                            <div class="list-group-item px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        @if($aplicacion->empleado && $aplicacion->empleado->foto_perfil)
                                            <img src="{{ asset($aplicacion->empleado->foto_perfil) }}" 
                                                 alt="Foto de perfil" 
                                                 class="rounded-circle"
                                                 width="48" height="48"
                                                 style="object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" 
                                                 style="width: 48px; height: 48px;">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0 fw-semibold">{{ $aplicacion->empleado->nombre ?? 'Usuario' }}</h6>
                                            <small class="text-muted">{{ $aplicacion->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-0 small text-muted">
                                            Aplicó a: {{ $aplicacion->oferta->titulo }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Job Posts -->
        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm rounded-3">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
                    <h5 class="mb-0 fw-semibold text-dark">
                        <i class="fas fa-briefcase me-2 text-success"></i>Ofertas Recientes
                    </h5>
                    <a href="{{ route('empleador.ofertas.index') }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                        Ver Todas
                    </a>
                </div>
                <div class="card-body p-0">
                    @if($ofertasRecientes->isEmpty())
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-briefcase fa-3x text-muted"></i>
                            </div>
                            <p class="text-muted mb-0">No hay ofertas publicadas</p>
                            <a href="{{ route('empleador.ofertas.create') }}" class="btn btn-success mt-3">
                                <i class="fas fa-plus me-1"></i> Crear Oferta
                            </a>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($ofertasRecientes as $oferta)
                            <div class="list-group-item px-4 py-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1 fw-semibold">{{ $oferta->titulo }}</h6>
                                        <p class="mb-0 small text-muted">
                                            <i class="fas fa-map-marker-alt me-1"></i>{{ $oferta->ubicacion }}
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-clock me-1"></i>{{ $oferta->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <span class="badge bg-{{ $oferta->estado === 'activa' ? 'success' : 'secondary' }} rounded-pill">
                                        {{ ucfirst($oferta->estado) }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-semibold text-dark">
                        <i class="fas fa-bolt me-2 text-warning"></i>Acciones Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <a href="{{ route('empleador.ofertas.create') }}" 
                               class="card h-100 border-0 bg-success bg-opacity-10 text-success text-decoration-none rounded-3 text-center p-4">
                                <div class="card-body">
                                    <i class="fas fa-plus-circle fa-2x mb-3"></i>
                                    <h6 class="mb-0">Crear Nueva Oferta</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('empleador.candidatos') }}" 
                               class="card h-100 border-0 bg-primary bg-opacity-10 text-primary text-decoration-none rounded-3 text-center p-4">
                                <div class="card-body">
                                    <i class="fas fa-users fa-2x mb-3"></i>
                                    <h6 class="mb-0">Ver Candidatos</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('empleador.perfil') }}" 
                               class="card h-100 border-0 bg-warning bg-opacity-10 text-warning text-decoration-none rounded-3 text-center p-4">
                                <div class="card-body">
                                    <i class="fas fa-building fa-2x mb-3"></i>
                                    <h6 class="mb-0">Editar Empresa</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

