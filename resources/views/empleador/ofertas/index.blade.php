@extends('layouts.empleador')

@section('page-title', 'Mis Ofertas de Trabajo')
@section('page-description', 'Gestiona tus ofertas de trabajo publicadas')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2">Mis Ofertas de Trabajo</h1>
            <p class="text-muted">Gestiona tus ofertas de trabajo publicadas</p>
        </div>
        <a href="{{ route('empleador.ofertas.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle me-2"></i>Nueva Oferta
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <!-- Estadísticas rápidas -->
        <div class="col-12 mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 bg-primary bg-opacity-10 rounded p-3">
                                    <i class="fas fa-briefcase text-primary fa-2x"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-muted mb-1">Total Ofertas</h6>
                                    <h4 class="mb-0">{{ $ofertas->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 bg-success bg-opacity-10 rounded p-3">
                                    <i class="fas fa-check-circle text-success fa-2x"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-muted mb-1">Ofertas Activas</h6>
                                    <h4 class="mb-0">{{ $ofertas->where('estado', 'activa')->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 bg-warning bg-opacity-10 rounded p-3">
                                    <i class="fas fa-users text-warning fa-2x"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-muted mb-1">Total Candidatos</h6>
                                    <h4 class="mb-0">{{ $ofertas->sum(function($oferta) { return $oferta->aplicaciones->count(); }) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 bg-info bg-opacity-10 rounded p-3">
                                    <i class="fas fa-clock text-info fa-2x"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="text-muted mb-1">Pendientes Revisión</h6>
                                    <h4 class="mb-0">{{ $ofertas->sum(function($oferta) { return $oferta->aplicaciones->where('estado', 'pendiente')->count(); }) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Ofertas -->
        @forelse($ofertas as $oferta)
        <div class="col-12 col-lg-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="card-title mb-1">{{ $oferta->titulo }}</h5>
                            <span class="badge bg-{{ $oferta->categoria === 'tecnologia' ? 'info' : 
                                                    ($oferta->categoria === 'ventas' ? 'success' : 
                                                    ($oferta->categoria === 'marketing' ? 'primary' : 'secondary')) }} me-2">
                                {{ ucfirst($oferta->categoria) }}
                            </span>
                            <span class="badge bg-{{ $oferta->estado === 'activa' ? 'success' : 'secondary' }}">
                                {{ ucfirst($oferta->estado) }}
                            </span>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-link text-dark p-0" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('empleador.ofertas.show', $oferta->id) }}">
                                        <i class="fas fa-eye text-primary me-2"></i>Ver Detalles
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('empleador.ofertas.edit', $oferta->id) }}">
                                        <i class="fas fa-edit text-success me-2"></i>Editar
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('empleador.ofertas.destroy', $oferta->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger" 
                                                onclick="return confirm('¿Estás seguro de que deseas eliminar esta oferta?')">
                                            <i class="fas fa-trash-alt me-2"></i>Eliminar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <span>{{ $oferta->ubicacion }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-money-bill-wave text-success me-2"></i>
                            <span>
                                @if($oferta->salario && $oferta->salario_max)
                                    {{ number_format($oferta->salario, 2) }}€ - {{ number_format($oferta->salario_max, 2) }}€
                                @elseif($oferta->salario)
                                    {{ number_format($oferta->salario, 2) }}€
                                @else
                                    Salario no especificado
                                @endif
                            </span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-briefcase text-info me-2"></i>
                            <span>{{ $oferta->tipo_contrato }} - {{ $oferta->jornada }}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-signal text-warning me-2"></i>
                            <span>{{ $oferta->nivel_experiencia }}</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <div class="me-4">
                            <i class="fas fa-users text-primary me-2"></i>
                            <span>{{ $oferta->aplicaciones->count() }} candidatos</span>
                        </div>
                        @if($oferta->fecha_limite)
                        <div>
                            <i class="fas fa-calendar-alt text-danger me-2"></i>
                            <span>Expira: {{ \Carbon\Carbon::parse($oferta->fecha_limite)->format('d/m/Y') }}</span>
                        </div>
                        @endif
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('empleador.ofertas.show', $oferta->id) }}" class="btn btn-outline-primary btn-sm flex-grow-1">
                            <i class="fas fa-eye me-1"></i>Ver Detalles
                        </a>
                        <a href="{{ route('empleador.ofertas.edit', $oferta->id) }}" class="btn btn-outline-success btn-sm flex-grow-1">
                            <i class="fas fa-edit me-1"></i>Editar
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <img src="{{ asset('images/empty-offers.svg') }}" alt="No hay ofertas" class="mb-4" style="max-width: 200px;">
                <h4>No hay ofertas publicadas</h4>
                <p class="text-muted">Comienza publicando tu primera oferta de trabajo</p>
                <a href="{{ route('empleador.ofertas.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle me-2"></i>Crear Nueva Oferta
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
    }

    .dropdown-item:hover {
        background-color: rgba(40, 167, 69, 0.1);
    }

    .dropdown-item.text-danger:hover {
        background-color: rgba(220, 53, 69, 0.1);
    }

    .badge {
        padding: 0.5em 0.8em;
        font-weight: 500;
    }
</style>
@endpush
@endsection