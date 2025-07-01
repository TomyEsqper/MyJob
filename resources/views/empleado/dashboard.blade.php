@extends('layouts.empleado')

@section('page-title', '¡Bienvenido de nuevo!')
@section('page-description', 'Aquí tienes un resumen de tu actividad reciente y estadísticas.')

@section('content')
@if (session('success'))
    <x-notification type="success" :message="session('success')" title="¡Éxito!" />
@endif
@if (session('error'))
    <x-notification type="error" :message="session('error')" title="¡Error!" />
@endif
@if (session('warning'))
    <x-notification type="warning" :message="session('warning')" title="¡Atención!" />
@endif
@if ($errors->any())
    <x-notification type="error" :message="$errors->first()" title="Error de validación" />
@endif

<div class="dashboard-hero mb-5 p-4 rounded-4 d-flex align-items-center gap-4 animate__animated animate__fadeInDown" style="background: linear-gradient(90deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: #fff; box-shadow: 0 8px 32px 0 rgba(31,38,135,0.10);">
    <div class="dashboard-avatar flex-shrink-0">
        <img src="{{ Auth::user()->foto_perfil ? (Str::startsWith(Auth::user()->foto_perfil, 'http') ? Auth::user()->foto_perfil : asset('storage/' . Auth::user()->foto_perfil)) : asset('images/default-user.png') }}" class="rounded-circle shadow" width="80" height="80" style="object-fit: cover; border: 4px solid #fff; background: #f8f9fa;">
    </div>
    <div>
        <h1 class="mb-1" style="font-weight: 800; font-size: 2.2rem; letter-spacing: 1px;">¡Hola, {{ Auth::user()->nombre_usuario }}
        @if(Auth::user()->verificado || Auth::user()->destacado)
            <span title="Usuario verificado" style="color:#3b82f6; font-size:1.1em; vertical-align:middle; margin-left:0.2em;"><i class="fa-solid fa-circle-check"></i></span>
        @endif
        !</h1>
        <div class="mb-1" style="font-size: 1.15rem; opacity: 0.93;">Te damos la bienvenida a tu espacio de oportunidades.</div>
        <div class="fw-bold" style="font-size: 1.05rem; opacity: 0.85;">"El éxito es la suma de pequeños esfuerzos repetidos cada día."</div>
    </div>
</div>
<section class="stats-row-empleado mb-4 animate__animated animate__fadeInUp">
    <div class="stat-card-empleado d-flex align-items-center gap-3" style="min-width:200px;">
        <div class="stat-icon d-flex align-items-center justify-content-center" style="width:60px;height:60px;border-radius:50%;margin-right:1rem;"><i class="fas fa-paper-plane"></i></div>
        <div>
            <div class="stat-value">{{ $aplicacionesEnviadas }}</div>
            <div class="stat-label text-uppercase" style="font-weight:700;letter-spacing:1.5px;">Aplicaciones Enviadas</div>
        </div>
    </div>
    <div class="stat-card-empleado d-flex align-items-center gap-3" style="min-width:200px;">
        <div class="stat-icon d-flex align-items-center justify-content-center" style="width:60px;height:60px;border-radius:50%;margin-right:1rem;"><i class="fas fa-eye"></i></div>
        <div>
            <div class="stat-value">{{ $vistasPerfilCount }}</div>
            <div class="stat-label text-uppercase" style="font-weight:700;letter-spacing:1.5px;">Vistas de Perfil</div>
        </div>
    </div>
    <div class="stat-card-empleado d-flex align-items-center gap-3" style="min-width:200px;">
        <div class="stat-icon d-flex align-items-center justify-content-center" style="width:60px;height:60px;border-radius:50%;margin-right:1rem;"><i class="fas fa-check-circle"></i></div>
        <div>
            <div class="stat-value">{{ $entrevistasCount }}</div>
            <div class="stat-label text-uppercase" style="font-weight:700;letter-spacing:1.5px;">Entrevistas Programadas</div>
        </div>
    </div>
</section>
<script>
document.querySelectorAll('.stat-card-empleado').forEach(function(card, idx) {
    const icons = [
        '<i class="fas fa-paper-plane"></i>',
        '<i class="fas fa-eye"></i>',
        '<i class="fas fa-check-circle"></i>'
    ];
    card.querySelector('.stat-icon').innerHTML = icons[idx];
});
</script>
<section class="card-empleado mb-4 animate__animated animate__fadeInUp animate__delay-1s">
    <div class="card-header-empleado d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Entrevistas Programadas</h5>
    </div>
    <div class="card-body-empleado">
        @if($entrevistasProgramadas->count())
            <ul class="list-group list-group-flush">
                @foreach($entrevistasProgramadas as $entrevista)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('empleado.ofertas.show', $entrevista->oferta) }}" style="font-weight:bold; text-decoration:underline; color:#219150;">
                                {{ $entrevista->oferta->titulo }}
                            </a><br>
                            <small class="text-muted">{{ $entrevista->oferta->empleador->empleador->nombre_empresa ?? $entrevista->oferta->empleador->nombre_usuario ?? 'Empresa no especificada' }}</small>
                            @if($entrevista->entrevista)
                                <div class="mt-1">
                                    <span class="badge bg-info text-dark">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ \Carbon\Carbon::parse($entrevista->entrevista->fecha_hora)->format('d/m/Y H:i') }}
                                        @if($entrevista->entrevista->lugar)
                                            | <i class="fas fa-map-marker-alt me-1"></i>{{ $entrevista->entrevista->lugar }}
                                        @endif
                                    </span>
                                    @if($entrevista->entrevista->notas)
                                        <div class="small text-muted mt-1">{{ $entrevista->entrevista->notas }}</div>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <span class="badge bg-success">Aceptada el {{ $entrevista->updated_at->format('d/m/Y') }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="text-center py-4">
                <i class="fas fa-calendar-check fa-2x text-muted mb-2"></i>
                <p class="text-muted mb-0">No tienes entrevistas programadas aún.</p>
            </div>
        @endif
    </div>
</section>
<section class="card-empleado mb-4 animate__animated animate__fadeInUp animate__delay-2s">
    <div class="card-header-empleado d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Ofertas Disponibles</h5>
        <a href="#" class="btn btn-outline-success btn-sm">Ver Más</a>
    </div>
    <div class="card-body-empleado">
        @forelse($ofertas as $oferta)
            <div class="job-card-empleado p-4 border-bottom position-relative">
                <div class="row align-items-center">
                    <div class="col-auto">
                        {{-- Eliminar logo de empresa --}}
                        {{-- <div class="company-logo bg-light rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            @if($oferta->empleador && $oferta->empleador->logo_empresa)
                                <img src="{{ $oferta->empleador->logo_empresa }}" alt="Logo" class="img-fluid rounded-circle" style="max-width: 60px; max-height: 60px;">
                            @endif
                        </div> --}}
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
                                    COP ${{ number_format($oferta->salario_minimo, 0, ',', '.') }} - COP ${{ number_format($oferta->salario_maximo, 0, ',', '.') }}
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
                            @php
                                $yaAplicado = Auth::user()->aplicaciones()->where('oferta_id', $oferta->id)->exists();
                            @endphp
                            @if($yaAplicado)
                                <form action="{{ route('empleado.desaplicar', $oferta) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas retirar tu postulación?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-times me-1"></i> Retirar Postulación
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('empleado.aplicar', $oferta) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-paper-plane me-1"></i> Aplicar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <p class="text-muted mb-0">No hay ofertas disponibles en este momento</p>
                <a href="{{ route('empleado.buscar') }}" class="btn btn-success dashboard-empty-btn mt-3">
                    <i class="fas fa-search me-1"></i> Buscar Empleo
                </a>
            </div>
        @endforelse
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            let firstError = null;
            form.querySelectorAll('[required]').forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('input-error');
                    if (!firstError) firstError = input;
                } else {
                    input.classList.remove('input-error');
                }
            });
            if (firstError) {
                e.preventDefault();
                showNotification({type: 'error', message: 'Por favor completa todos los campos obligatorios.', title: 'Campos requeridos'});
                firstError.focus();
            }
        });
    });
});
</script>
@endsection
