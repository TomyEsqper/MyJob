@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <div class="text-center mb-4">
                    <img src="{{ Auth::user()->foto_perfil ?? asset('images/default-user.png') }}" class="rounded-circle" width="80" height="80">
                    <h6 class="mt-2">{{ Auth::user()->nombre_usuario }}</h6>
                </div>
                <ul class="nav flex-column mt-4">
                    <li class="nav-item">
                        <a href="{{ route('empleador.dashboard') }}" class="nav-link">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('empleador.candidatos') }}" class="nav-link active">
                            <i class="fas fa-users"></i> Candidatos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('empleador.ofertas.index') }}" class="nav-link">
                            <i class="fas fa-briefcase"></i> Ofertas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('empleador.perfil') }}" class="nav-link">
                            <i class="fas fa-building"></i> Mi Empresa
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <div>
                    <h1 class="h2">Perfil del Candidato</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('empleador.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('empleador.candidatos') }}">Candidatos</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $usuario->nombre_usuario }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('empleador.candidatos') }}" class="btn btn-sm btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-1"></i> Volver a Candidatos
                    </a>
                    @if($usuario->cv_path)
                        <a href="{{ asset($usuario->cv_path) }}" target="_blank" class="btn btn-sm btn-primary">
                            <i class="fas fa-file-pdf me-1"></i> Descargar CV
                        </a>
                    @endif
                </div>
            </div>

            <div class="row">
                <!-- Información Principal -->
                <div class="col-lg-4">
                    <!-- Perfil -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body text-center">
                            <div class="position-relative d-inline-block mb-3">
                                <img src="{{ $usuario->foto_perfil ?? asset('images/default-user.png') }}" 
                                     class="rounded-circle" width="120" height="120"
                                     style="object-fit: cover;">
                                @if($usuario->activo)
                                    <span class="position-absolute bottom-0 end-0 bg-success rounded-circle p-2"
                                          data-bs-toggle="tooltip" title="Disponible para trabajar">
                                        <span class="visually-hidden">Disponible</span>
                                    </span>
                                @endif
                            </div>
                            <h4 class="card-title mb-1">{{ $usuario->nombre_usuario }}</h4>
                            @if($usuario->profesion)
                                <p class="text-muted mb-2">{{ $usuario->profesion }}</p>
                            @endif
                            @if($usuario->ubicacion)
                                <p class="text-muted mb-3">
                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $usuario->ubicacion }}
                                </p>
                            @endif
                            <div class="d-grid gap-2">
                                <a href="mailto:{{ $usuario->correo_electronico }}" class="btn btn-primary">
                                    <i class="fas fa-envelope me-1"></i> Contactar
                                </a>
                                @if($usuario->cv_path)
                                    <a href="{{ asset($usuario->cv_path) }}" target="_blank" class="btn btn-outline-primary">
                                        <i class="fas fa-file-pdf me-1"></i> Ver CV
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <div class="row text-center">
                                <div class="col">
                                    <h6 class="mb-0">{{ $aplicaciones->count() }}</h6>
                                    <small class="text-muted">Aplicaciones</small>
                                </div>
                                <div class="col border-start">
                                    <h6 class="mb-0">{{ $aplicaciones->where('estado', 'aceptada')->count() }}</h6>
                                    <small class="text-muted">Aceptadas</small>
                                </div>
                                <div class="col border-start">
                                    <h6 class="mb-0">{{ $aplicaciones->where('estado', 'pendiente')->count() }}</h6>
                                    <small class="text-muted">Pendientes</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Contacto -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-address-card me-2"></i>Información de Contacto
                            </h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                @if($usuario->correo_electronico)
                                    <li class="mb-3">
                                        <div class="d-flex align-items-center">
                                            <span class="bg-light rounded-circle p-2 me-3">
                                                <i class="fas fa-envelope text-primary"></i>
                                            </span>
                                            <div>
                                                <small class="text-muted d-block">Email</small>
                                                <a href="mailto:{{ $usuario->correo_electronico }}" class="text-decoration-none">
                                                    {{ $usuario->correo_electronico }}
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                                @if($usuario->telefono)
                                    <li class="mb-3">
                                        <div class="d-flex align-items-center">
                                            <span class="bg-light rounded-circle p-2 me-3">
                                                <i class="fas fa-phone text-primary"></i>
                                            </span>
                                            <div>
                                                <small class="text-muted d-block">Teléfono</small>
                                                <a href="tel:{{ $usuario->telefono }}" class="text-decoration-none">
                                                    {{ $usuario->telefono }}
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                                @if($usuario->ubicacion)
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <span class="bg-light rounded-circle p-2 me-3">
                                                <i class="fas fa-map-marker-alt text-primary"></i>
                                            </span>
                                            <div>
                                                <small class="text-muted d-block">Ubicación</small>
                                                {{ $usuario->ubicacion }}
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- Habilidades -->
                    @if($usuario->habilidades)
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-tools me-2"></i>Habilidades
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach(explode(',', $usuario->habilidades) as $habilidad)
                                        <span class="badge bg-light text-dark">{{ trim($habilidad) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Contenido Principal -->
                <div class="col-lg-8">
                    <!-- Sobre el Candidato -->
                    @if($usuario->descripcion)
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-user me-2"></i>Sobre {{ $usuario->nombre_usuario }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ $usuario->descripcion }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Experiencia -->
                    @if($usuario->experiencia)
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-briefcase me-2"></i>Experiencia Laboral
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ $usuario->experiencia }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Educación -->
                    @if($usuario->educacion)
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-graduation-cap me-2"></i>Educación
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ $usuario->educacion }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Aplicaciones -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-paper-plane me-2"></i>Aplicaciones a tus Ofertas
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Oferta</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($aplicaciones as $aplicacion)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('empleador.ofertas.show', $aplicacion->oferta) }}" 
                                                       class="text-decoration-none">
                                                        {{ $aplicacion->oferta->titulo }}
                                                    </a>
                                                </td>
                                                <td>{{ $aplicacion->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $aplicacion->estado === 'pendiente' ? 'warning' : ($aplicacion->estado === 'aceptada' ? 'success' : 'danger') }}">
                                                        {{ ucfirst($aplicacion->estado) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-primary dropdown-toggle" 
                                                                data-bs-toggle="dropdown">
                                                            Acciones
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <form action="{{ route('empleador.aplicaciones.actualizar', $aplicacion->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="estado" value="aceptada">
                                                                    <button type="submit" class="dropdown-item text-success">
                                                                        <i class="fas fa-check me-1"></i> Aceptar
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('empleador.aplicaciones.actualizar', $aplicacion->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="estado" value="rechazada">
                                                                    <button type="submit" class="dropdown-item text-danger">
                                                                        <i class="fas fa-times me-1"></i> Rechazar
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                                        <p class="mb-0">Este candidato no ha aplicado a ninguna de tus ofertas.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

@push('styles')
<style>
    .sidebar {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .nav-link {
        color: #333;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        margin-bottom: 0.25rem;
    }
    
    .nav-link:hover {
        background-color: #f8f9fa;
    }
    
    .nav-link.active {
        background-color: #e9ecef;
        color: #0d6efd;
    }
    
    .card {
        border: none;
        margin-bottom: 1.5rem;
    }
    
    .card-header {
        background-color: #f8f9fa;
        border-bottom: none;
        padding: 1rem;
    }
    
    .badge {
        font-weight: 500;
        padding: 0.5em 0.75em;
    }
    
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
</style>
@endpush

@push('scripts')
<script>
    // Inicializar tooltips de Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
@endsection 