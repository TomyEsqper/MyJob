@extends('layouts.empleado')

@section('page-title', 'Detalle de la Oferta')
@section('page-description', 'Información completa de la oferta de empleo.')

@section('content')
<div class="card-empleado">
    <div class="card-header-empleado">
        <h5 class="mb-0">Detalle de la Oferta</h5>
    </div>
    <div class="card-body-empleado">
        @if(isset($oferta))
            <div class="row">
                <div class="col-md-8">
                    <h3 class="text-primary mb-3">{{ $oferta->titulo }}</h3>
                    <div class="mb-4">
                        <h6 class="text-muted">Descripción</h6>
                        <p>{{ $oferta->descripcion }}</p>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Requisitos</h6>
                            <p>{{ $oferta->requisitos ?? 'No especificados' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Responsabilidades</h6>
                            <p>{{ $oferta->responsabilidades ?? 'No especificadas' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title">Información de la Oferta</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-building text-muted me-2"></i>
                                    <strong>Empresa:</strong> {{ $oferta->empleador->empleador->nombre_empresa ?? 'No especificada' }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-map-marker-alt text-muted me-2"></i>
                                    <strong>Ubicación:</strong> {{ $oferta->ubicacion }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-clock text-muted me-2"></i>
                                    <strong>Tipo de Contrato:</strong> {{ $oferta->tipo_contrato }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-money-bill-wave text-muted me-2"></i>
                                    <strong>Salario:</strong> ${{ number_format($oferta->salario_minimo) }} - ${{ number_format($oferta->salario_maximo) }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-calendar text-muted me-2"></i>
                                    <strong>Publicada:</strong> {{ $oferta->created_at->diffForHumans() }}
                                </li>
                            </ul>
                            
                            <div class="d-grid gap-2 mt-3">
                                <form action="{{ route('empleado.aplicar', $oferta) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-paper-plane me-1"></i> Aplicar a esta Oferta
                                    </button>
                                </form>
                                <a href="{{ route('empleado.dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Volver al Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                <h5>Oferta no encontrada</h5>
                <p class="text-muted">La oferta que buscas no existe o ha sido eliminada.</p>
                <a href="{{ route('empleado.dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-1"></i> Volver al Dashboard
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 