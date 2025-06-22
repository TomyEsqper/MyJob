@extends('layouts.empleador')

@section('page-title', 'Candidatos')
@section('page-description', 'Gestiona y revisa las aplicaciones de los candidatos')

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
                    <h1 class="h2">Candidatos</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('empleador.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Candidatos</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Mensajes de Alerta -->
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Filtros -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form action="{{ route('empleador.candidatos') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label for="oferta" class="form-label">Filtrar por Oferta</label>
                            <select name="oferta" id="oferta" class="form-select">
                                <option value="">Todas las ofertas</option>
                                @foreach($ofertas as $oferta)
                                    <option value="{{ $oferta->id }}" {{ request('oferta') == $oferta->id ? 'selected' : '' }}>
                                        {{ $oferta->titulo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select name="estado" id="estado" class="form-select">
                                <option value="">Todos los estados</option>
                                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="aceptada" {{ request('estado') == 'aceptada' ? 'selected' : '' }}>Aceptada</option>
                                <option value="rechazada" {{ request('estado') == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="fecha" class="form-label">Ordenar por</label>
                            <select name="orden" id="orden" class="form-select">
                                <option value="reciente" {{ request('orden') == 'reciente' ? 'selected' : '' }}>Más recientes</option>
                                <option value="antiguo" {{ request('orden') == 'antiguo' ? 'selected' : '' }}>Más antiguos</option>
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

            <!-- Lista de Candidatos -->
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0">Candidato</th>
                                    <th class="border-0">Oferta</th>
                                    <th class="border-0">Fecha</th>
                                    <th class="border-0">Estado</th>
                                    <th class="border-0">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($aplicaciones as $aplicacion)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $aplicacion->empleado->foto_perfil ?? asset('images/default-user.png') }}" 
                                                     class="rounded-circle me-3" width="40" height="40">
                                                <div>
                                                    <h6 class="mb-0">{{ $aplicacion->empleado->nombre_usuario }}</h6>
                                                    <small class="text-muted">
                                                        {{ $aplicacion->empleado->profesion ?? 'No especificada' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('empleador.ofertas.show', $aplicacion->oferta) }}" class="text-decoration-none">
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
                                                <a href="{{ route('empleador.candidatos.show', $aplicacion->empleado) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i> Ver Perfil
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-primary dropdown-toggle dropdown-toggle-split" 
                                                        data-bs-toggle="dropdown">
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @if($aplicacion->empleado->cv_path)
                                                        <li>
                                                            <a class="dropdown-item" href="{{ asset($aplicacion->empleado->cv_path) }}" target="_blank">
                                                                <i class="fas fa-file-pdf me-1"></i> Ver CV
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <a class="dropdown-item" href="mailto:{{ $aplicacion->empleado->correo_electronico }}">
                                                            <i class="fas fa-envelope me-1"></i> Contactar
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
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
                                        <td colspan="5" class="text-center py-5">
                                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                            <p class="text-muted mb-0">No hay candidatos que mostrar</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @if($aplicaciones->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-center">
                            {{ $aplicaciones->links() }}
                        </div>
                    </div>
                @endif
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
    
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    
    .dropdown-toggle::after {
        margin-left: 0.5rem;
    }
    
    .badge {
        font-weight: 500;
        padding: 0.5em 0.75em;
    }
</style>
@endpush
@endsection 