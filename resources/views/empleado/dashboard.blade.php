@extends('layouts.empleado')

@section('page-title', '¡Bienvenido de nuevo!')
@section('page-description', 'Aquí tienes un resumen de tu actividad reciente y estadísticas.')

@section('content')
<div class="dashboard-hero mb-5 p-4 rounded-4 d-flex align-items-center gap-4 animate__animated animate__fadeInDown" style="background: linear-gradient(90deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: #fff; box-shadow: 0 8px 32px 0 rgba(31,38,135,0.10);">
    <div class="dashboard-avatar flex-shrink-0">
        <img src="{{ Auth::user()->foto_perfil ? (Str::startsWith(Auth::user()->foto_perfil, 'http') ? Auth::user()->foto_perfil : asset('storage/' . Auth::user()->foto_perfil)) : asset('images/default-user.png') }}" class="rounded-circle shadow" width="80" height="80" style="object-fit: cover; border: 4px solid #fff; background: #f8f9fa;">
    </div>
    <div>
        <h1 class="mb-1" style="font-weight: 800; font-size: 2.2rem; letter-spacing: 1px;">¡Hola, {{ Auth::user()->nombre_usuario }}!</h1>
        <div class="mb-1" style="font-size: 1.15rem; opacity: 0.93;">Te damos la bienvenida a tu espacio de oportunidades.</div>
        <div class="fw-bold" style="font-size: 1.05rem; opacity: 0.85;">"El éxito es la suma de pequeños esfuerzos repetidos cada día."</div>
    </div>
</div>
<section class="stats-row-empleado mb-4 animate__animated animate__fadeInUp">
    <div class="stat-card-empleado">
        <div class="stat-icon"><i class="fas fa-paper-plane"></i></div>
        <div>
            <div class="stat-value">{{ $aplicacionesEnviadas }}</div>
            <div class="stat-label">Aplicaciones Enviadas</div>
        </div>
    </div>
    <div class="stat-card-empleado">
        <div class="stat-icon"><i class="fas fa-eye"></i></div>
        <div>
            <div class="stat-value">{{ $vistasPerfilCount }}</div>
            <div class="stat-label">Vistas de Perfil</div>
        </div>
    </div>
    <div class="stat-card-empleado">
        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
        <div>
            <div class="stat-value">{{ $entrevistasCount }}</div>
            <div class="stat-label">Entrevistas Programadas</div>
        </div>
    </div>
</section>
<section class="card-empleado mb-4 animate__animated animate__fadeInUp animate__delay-1s">
    <div class="card-header-empleado d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Aplicaciones Recientes</h5>
        <a href="{{ route('empleado.aplicaciones') }}" class="btn btn-outline-success btn-sm">Ver Todas</a>
    </div>
    <div class="card-body-empleado">
        @forelse($aplicacionesRecientes as $aplicacion)
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
                <p class="text-muted mb-0">No hay aplicaciones recientes</p>
                <a href="{{ route('empleado.buscar') }}" class="btn btn-success mt-3">
                    <i class="fas fa-search me-1"></i> Buscar Ofertas
                </a>
            </div>
        @endforelse
    </div>
</section>
<section class="card-empleado animate__animated animate__fadeInUp animate__delay-2s">
    <div class="card-header-empleado d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Ofertas Disponibles</h5>
        <a href="#" class="btn btn-outline-success btn-sm">Ver Más</a>
    </div>
    <div class="card-body-empleado">
        @forelse($ofertas as $oferta)
            <div class="job-card-empleado p-4 border-bottom position-relative">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="company-logo bg-light rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            @if($oferta->empleador && $oferta->empleador->logo_empresa)
                                <img src="{{ $oferta->empleador->logo_empresa }}" alt="Logo" class="img-fluid rounded-circle" style="max-width: 60px; max-height: 60px;">
                            @else
                                <i class="fas fa-building text-primary" style="font-size: 2rem;"></i>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <div class="job-info">
                            <h4 class="mb-1 text-primary">{{ $oferta->titulo }}</h4>
                            <p class="mb-2 text-muted">
                                <i class="fas fa-building me-2"></i>
                                {{ $oferta->empleador->empleador->nombre_empresa ?? 'Empresa desconocida' }}
                            </p>
                            <div class="d-flex flex-wrap gap-3">
                                <span class="text-muted small">
                                    <i class="fas fa-map-marker-alt me-1 text-secondary"></i>
                                    {{ $oferta->ubicacion }}
                                </span>
                                <span class="text-muted small">
                                    <i class="fas fa-clock me-1 text-secondary"></i>
                                    {{ $oferta->tipo_contrato }}
                                </span>
                                <span class="text-muted small">
                                    <i class="fas fa-money-bill-wave me-1 text-secondary"></i>
                                    ${{ number_format($oferta->salario_minimo) }} - ${{ number_format($oferta->salario_maximo) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-auto mt-3 mt-md-0">
                        <div class="job-actions d-flex gap-2 justify-content-md-end">
                            <a href="{{ route('empleado.ofertas.show', $oferta) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i> Ver Detalle
                            </a>
                            <form action="{{ route('empleado.aplicar', $oferta) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-paper-plane me-1"></i> Aplicar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <p class="text-muted mb-0">No hay ofertas disponibles en este momento</p>
                <a href="{{ route('empleado.buscar') }}" class="btn btn-success mt-3">
                    <i class="fas fa-search me-1"></i> Buscar Empleo
                </a>
            </div>
        @endforelse
    </div>
</section>
@endsection
