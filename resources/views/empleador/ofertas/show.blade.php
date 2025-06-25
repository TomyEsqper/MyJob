@extends('layouts.empleador')

@section('page-title', 'Detalle de la Oferta')
@section('page-description', 'Información completa de la oferta de empleo.')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detalle de la Oferta</h5>
        <div>
            <a href="{{ route('empleador.ofertas.edit', $oferta->id) }}" class="btn btn-success btn-sm">
                <i class="fas fa-edit me-1"></i>Editar Oferta
            </a>
            <a href="{{ route('empleador.ofertas.index') }}" class="btn btn-secondary btn-sm ms-2">
                <i class="fas fa-arrow-left me-1"></i>Volver
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <h3 class="text-primary mb-3">{{ $oferta->titulo }}</h3>
                
                <!-- Información Principal -->
                <div class="mb-4">
                    <h6 class="text-muted mb-3">Información Principal</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-building text-primary me-2"></i>
                                <span><strong>Categoría:</strong> {{ $oferta->categoria }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                <span><strong>Ubicación:</strong> {{ $oferta->ubicacion }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-money-bill-wave text-success me-2"></i>
                                <span><strong>Salario:</strong> COP ${{ number_format($oferta->salario, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-briefcase text-info me-2"></i>
                                <span><strong>Tipo de Contrato:</strong> {{ $oferta->tipo_contrato }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock text-warning me-2"></i>
                                <span><strong>Jornada:</strong> {{ $oferta->jornada }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-signal text-primary me-2"></i>
                                <span><strong>Experiencia:</strong> {{ $oferta->nivel_experiencia }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-laptop-house text-secondary me-2"></i>
                                <span><strong>Modalidad:</strong> {{ $oferta->modalidad_trabajo }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-alt text-danger me-2"></i>
                                <span><strong>Fecha Límite:</strong> 
                                    {{ $oferta->fecha_limite ? \Carbon\Carbon::parse($oferta->fecha_limite)->format('d/m/Y') : 'Sin fecha límite' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="mb-4">
                    <h6 class="text-muted mb-3">Descripción</h6>
                    <p class="text-justify">{{ $oferta->descripcion }}</p>
                </div>

                <!-- Requisitos -->
                <div class="mb-4">
                    <h6 class="text-muted mb-3">Requisitos</h6>
                    <p class="text-justify">{{ $oferta->requisitos }}</p>
                </div>

                <!-- Responsabilidades -->
                @if($oferta->responsabilidades)
                <div class="mb-4">
                    <h6 class="text-muted mb-3">Responsabilidades</h6>
                    <p class="text-justify">{{ $oferta->responsabilidades }}</p>
                </div>
                @endif

                <!-- Beneficios -->
                @if($oferta->beneficios && count($oferta->beneficios) > 0)
                <div class="mb-4">
                    <h6 class="text-muted mb-3">Beneficios</h6>
                    <div class="row g-2">
                        @foreach($oferta->beneficios as $beneficio)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>{{ $beneficio }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Panel Lateral -->
            <div class="col-md-4">
                <!-- Estado de la Oferta -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title">Estado de la Oferta</h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-{{ $oferta->estado === 'activa' ? 'success' : 'danger' }} px-3 py-2">
                                {{ ucfirst($oferta->estado) }}
                            </span>
                            <small class="text-muted">
                                Creada {{ $oferta->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title">Estadísticas</h6>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span>Total de aplicaciones:</span>
                            <span class="badge bg-primary">{{ $oferta->aplicaciones->count() }}</span>
                        </div>
                        <a href="{{ route('empleador.candidatos') }}?oferta={{ $oferta->id }}" class="btn btn-outline-primary btn-sm w-100">
                            <i class="fas fa-users me-1"></i>Ver Candidatos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 