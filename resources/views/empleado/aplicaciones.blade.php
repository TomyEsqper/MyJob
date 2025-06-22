@extends('layouts.empleado')

@section('page-title', 'Mis Aplicaciones')
@section('page-description', 'Consulta y gestiona tus aplicaciones recientes.')

@section('content')
<section class="card-empleado mb-4">
    <div class="card-header-empleado d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Filtrar Aplicaciones</h5>
    </div>
    <div class="card-body-empleado">
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
                <button type="submit" class="btn btn-success w-100">
                    <i class="fas fa-filter me-1"></i> Filtrar
                </button>
            </div>
        </form>
    </div>
</section>
<section class="card-empleado">
    <div class="card-header-empleado d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Mis Aplicaciones</h5>
        <a href="{{ route('empleado.buscar') }}" class="btn btn-outline-success btn-sm">
            <i class="fas fa-search"></i> Buscar Nuevas Ofertas
        </a>
    </div>
    <div class="card-body-empleado">
        @forelse($aplicaciones as $aplicacion)
            <div class="job-card-empleado">
                <div class="company-logo-empleado">
                    @if($aplicacion->oferta->empleador->empleador && $aplicacion->oferta->empleador->empleador->logo_empresa)
                        <img src="{{ asset($aplicacion->oferta->empleador->empleador->logo_empresa) }}" alt="Logo" class="rounded" width="40" height="40">
                    @else
                        <i class="fas fa-building"></i>
                    @endif
                </div>
                <div class="job-info-empleado">
                    <h4>{{ $aplicacion->oferta->titulo }}</h4>
                    <p>{{ $aplicacion->oferta->empleador->nombre_usuario }} • {{ $aplicacion->oferta->ubicacion }} • {{ $aplicacion->created_at->diffForHumans() }}</p>
                </div>
                <div class="job-actions-empleado">
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
                <a href="{{ route('empleado.buscar') }}" class="btn btn-success mt-3">
                    <i class="fas fa-search me-1"></i> Buscar Ofertas
                </a>
            </div>
        @endforelse
    </div>
    @if($aplicaciones->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $aplicaciones->links() }}
        </div>
    @endif
</section>
@endsection 