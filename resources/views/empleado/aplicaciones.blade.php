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
                        <a href="{{ route('empleado.dashboard') }}" class="nav-link">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('empleado.aplicaciones') }}" class="nav-link active">
                            <i class="fas fa-briefcase text-success"></i> Mis Aplicaciones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('empleado.buscar') }}" class="nav-link">
                            <i class="fas fa-search"></i> Buscar Empleos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('empleado.cv') }}" class="nav-link">
                            <i class="fas fa-file-alt"></i> Mi CV
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('empleado.notificaciones') }}" class="nav-link">
                            <i class="fas fa-bell"></i> Notificaciones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('empleado.perfil') }}" class="nav-link">
                            <i class="fas fa-user"></i> Mi Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('empleado.configuracion') }}" class="nav-link">
                            <i class="fas fa-cog"></i> Configuración
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Mis Aplicaciones</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('empleado.buscar') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-search"></i> Buscar Nuevas Ofertas
                        </a>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('empleado.aplicaciones') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label for="estado" class="form-label">Estado</label>
                            <select name="estado" id="estado" class="form-select">
                                <option value="">Todos los estados</option>
                                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="revisada" {{ request('estado') == 'revisada' ? 'selected' : '' }}>En Revisión</option>
                                <option value="aceptada" {{ request('estado') == 'aceptada' ? 'selected' : '' }}>Aceptada</option>
                                <option value="rechazada" {{ request('estado') == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-1"></i> Filtrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Applications List -->
            <div class="card">
                <div class="card-body p-0">
                    @forelse($aplicaciones as $aplicacion)
                        <div class="job-card">
                            <div class="company-logo">
                                @if($aplicacion->oferta->empleador->empleador && $aplicacion->oferta->empleador->empleador->logo_empresa)
                                    <img src="{{ asset($aplicacion->oferta->empleador->empleador->logo_empresa) }}" alt="Logo" class="rounded" width="40" height="40">
                                @else
                                    <i class="fas fa-building"></i>
                                @endif
                            </div>
                            <div class="job-info">
                                <h4>{{ $aplicacion->oferta->titulo }}</h4>
                                <p>
                                    {{ $aplicacion->oferta->empleador->nombre_usuario }} • 
                                    {{ $aplicacion->oferta->ubicacion }} • 
                                    {{ $aplicacion->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <div class="job-actions">
                                @switch($aplicacion->estado)
                                    @case('aceptada')
                                        <span class="badge bg-success">Entrevista</span>
                                        @break
                                    @case('revisada')
                                        <span class="badge bg-warning text-dark">En Revisión</span>
                                        @break
                                    @case('rechazada')
                                        <span class="badge bg-danger">No Seleccionado</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">Pendiente</span>
                                @endswitch
                                <a href="{{ route('empleado.ofertas.show', $aplicacion->oferta) }}" class="btn btn-sm btn-outline-primary ms-2">
                                    <i class="fas fa-eye"></i> Ver Oferta
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No hay aplicaciones que mostrar</p>
                            <a href="{{ route('empleado.buscar') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-search me-1"></i> Buscar Ofertas
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if($aplicaciones->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $aplicaciones->links() }}
                </div>
            @endif
        </main>
    </div>
</div>

@push('styles')
<style>
.job-card {
    display: flex;
    align-items: center;
    padding: 1.25rem;
    border-bottom: 1px solid #e9ecef;
    transition: background-color 0.2s;
}

.job-card:hover {
    background-color: #f8f9fa;
}

.job-card:last-child {
    border-bottom: none;
}

.company-logo {
    width: 50px;
    height: 50px;
    background: #f8f9fa;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
}

.company-logo i {
    font-size: 1.5rem;
    color: #6c757d;
}

.job-info {
    flex: 1;
}

.job-info h4 {
    font-size: 1rem;
    margin-bottom: 0.25rem;
    color: #212529;
}

.job-info p {
    font-size: 0.875rem;
    color: #6c757d;
    margin-bottom: 0;
}

.job-actions {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.job-actions .badge {
    font-weight: 500;
    padding: 0.5em 0.75em;
}

.sidebar {
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100;
    padding: 48px 0 0;
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
}

.sidebar .nav-link {
    font-weight: 500;
    color: #333;
}

.sidebar .nav-link.active {
    color: #007bff;
}
</style>
@endpush
@endsection 