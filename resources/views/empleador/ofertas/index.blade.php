@extends('layouts.empleador')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Mis Ofertas de Trabajo</h1>
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
        @forelse($ofertas as $oferta)
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="position-absolute top-0 start-0 w-100" style="height: 4px; background-color: #28a745;"></div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="card-title mb-0">{{ $oferta->titulo }}</h5>
                        <span class="badge bg-{{ $oferta->estado === 'activa' ? 'success' : 'secondary' }}">
                            {{ ucfirst($oferta->estado) }}
                        </span>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <span>{{ $oferta->ubicacion }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-money-bill-wave text-success me-2"></i>
                            <span>{{ $oferta->salario ? number_format($oferta->salario, 2) . '€' : 'Salario no especificado' }}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock text-info me-2"></i>
                            <span>{{ $oferta->tipo_contrato }}</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-users text-warning me-2"></i>
                        <span>{{ $oferta->aplicaciones->count() }} candidatos</span>
                    </div>

                    <div class="text-muted small mb-3">
                        <i class="fas fa-calendar-alt me-1"></i>
                        Publicado {{ $oferta->created_at->diffForHumans() }}
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('empleador.ofertas.show', $oferta->id) }}" class="btn btn-outline-primary btn-sm flex-grow-1">
                            <i class="fas fa-eye me-1"></i>Ver Detalles
                        </a>
                        <a href="{{ route('empleador.ofertas.edit', $oferta->id) }}" class="btn btn-outline-success btn-sm flex-grow-1">
                            <i class="fas fa-edit me-1"></i>Editar
                        </a>
                        <form action="{{ route('empleador.ofertas.destroy', $oferta->id) }}" method="POST" class="d-inline flex-grow-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('¿Estás seguro de que deseas eliminar esta oferta?')">
                                <i class="fas fa-trash-alt me-1"></i>Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
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
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }

    .btn {
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }
</style>
@endpush
@endsection