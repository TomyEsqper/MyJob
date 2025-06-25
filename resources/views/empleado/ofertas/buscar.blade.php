@extends('layouts.empleado')

@section('page-title', 'Buscar Empleo')
@section('page-description', 'Encuentra ofertas de trabajo que se adapten a tu perfil.')

@section('content')
<div class="busqueda-header">
    <i class="fas fa-search icono-busqueda"></i>
    <h2>Buscar Empleo</h2>
    <p>Descubre oportunidades increíbles que se adapten perfectamente a tu perfil profesional</p>
</div>

<div class="busqueda-form-card">
    <form method="GET" action="{{ route('empleado.buscar') }}" class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label">Título del puesto</label>
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0">
                    <i class="fas fa-briefcase text-muted"></i>
                </span>
                <input type="text" name="titulo" class="form-control border-start-0" placeholder="Ej: Mesero, Limpieza, Seguridad" value="{{ old('titulo', $filtros['titulo'] ?? '') }}">
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label">Ubicación</label>
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0">
                    <i class="fas fa-map-marker-alt text-muted"></i>
                </span>
                <input type="text" name="ubicacion" class="form-control border-start-0" placeholder="Ej: Centro, Sur, Norte" value="{{ old('ubicacion', $filtros['ubicacion'] ?? '') }}">
            </div>
        </div>
        <div class="col-md-3">
            <label class="form-label">Tipo de Contrato</label>
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0">
                    <i class="fas fa-clock text-muted"></i>
                </span>
                <select name="tipo_contrato" class="form-select border-start-0">
                    <option value="">Todos los tipos</option>
                    <option value="Tiempo completo" {{ (isset($filtros['tipo_contrato']) && $filtros['tipo_contrato'] == 'Tiempo completo') ? 'selected' : '' }}>Tiempo completo</option>
                    <option value="Medio tiempo" {{ (isset($filtros['tipo_contrato']) && $filtros['tipo_contrato'] == 'Medio tiempo') ? 'selected' : '' }}>Medio tiempo</option>
                    <option value="Temporal" {{ (isset($filtros['tipo_contrato']) && $filtros['tipo_contrato'] == 'Temporal') ? 'selected' : '' }}>Temporal</option>
                    <option value="Prácticas" {{ (isset($filtros['tipo_contrato']) && $filtros['tipo_contrato'] == 'Prácticas') ? 'selected' : '' }}>Prácticas</option>
                </select>
            </div>
        </div>
        <div class="col-md-1 d-grid">
            <button type="submit" class="btn btn-busqueda">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
</div>

<div class="card-empleado">
    <div class="card-header-empleado d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-list-ul me-2"></i>
            Resultados de la búsqueda
        </h5>
        <span class="badge bg-primary fs-6">{{ $ofertas->total() }} ofertas encontradas</span>
    </div>
    <div class="card-body-empleado">
        @if($ofertas->count())
            <div class="row g-4">
                @foreach($ofertas as $oferta)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="resultado-oferta-card">
                            <div class="d-flex align-items-start mb-3">
                                <div class="company-logo-empleado flex-shrink-0 me-3">
                                    @if($oferta->empleador && $oferta->empleador->logo_empresa)
                                        <img src="{{ $oferta->empleador->logo_empresa }}" alt="Logo" class="img-fluid rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <i class="fas fa-building"></i>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h5>{{ $oferta->titulo }}</h5>
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $oferta->created_at->diffForHumans() }}
                                        </small>
                                        <span class="badge bg-success">{{ $oferta->tipo_contrato }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <p class="text-muted mb-2" style="line-height: 1.5;">
                                    {{ Str::limit($oferta->descripcion, 120) }}
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <div class="d-flex align-items-center text-muted mb-1">
                                            <i class="fas fa-building me-2"></i>
                                            <small>{{ $oferta->empleador->empleador->nombre_empresa ?? 'Empresa no especificada' }}</small>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex align-items-center text-muted mb-1">
                                            <i class="fas fa-map-marker-alt me-2"></i>
                                            <small>{{ $oferta->ubicacion }}</small>
                                        </div>
                                    </div>
                                    @if($oferta->salario)
                                    <div class="col-12">
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="fas fa-dollar-sign me-2"></i>
                                            <small>{{ $oferta->salario }}</small>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mt-auto">
                                <a href="{{ route('empleado.ofertas.show', $oferta) }}" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-eye me-2"></i>
                                    Ver Detalle
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            @if($ofertas->hasPages())
                <div class="mt-4">
                    {{ $ofertas->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-search fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted mb-2">No se encontraron ofertas</h4>
                    <p class="text-muted mb-0">Intenta ajustar los criterios de búsqueda para encontrar más oportunidades.</p>
                </div>
                <div class="mt-4">
                    <a href="{{ route('empleado.buscar') }}" class="btn btn-primary">
                        <i class="fas fa-redo me-2"></i>
                        Limpiar Filtros
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 