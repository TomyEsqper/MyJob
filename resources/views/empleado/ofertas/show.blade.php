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
                        <a href="{{ route('empleado.aplicaciones') }}" class="nav-link">
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

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('empleado.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detalles de la Oferta</li>
                    </ol>
                </nav>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('empleado.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Volver al Dashboard
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <!-- Cabecera de la oferta -->
                    <div class="card shadow-sm mb-4 border-0 position-relative overflow-hidden">
                        <div class="position-absolute top-0 start-0 w-100 bg-primary" style="height: 5px;"></div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
                                <div class="company-logo bg-light rounded-circle p-3 me-4 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                    @if($oferta->empleador && $oferta->empleador->logo_empresa)
                                        <img src="{{ $oferta->empleador->logo_empresa }}" alt="Logo" class="img-fluid rounded-circle" style="max-width: 80px; max-height: 80px;">
                                    @else
                                        <i class="fas fa-building text-primary" style="font-size: 2.5rem;"></i>
                                    @endif
                                </div>
                                <div>
                                    <h1 class="h3 mb-2">{{ $oferta->titulo }}</h1>
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-building me-2"></i>
                                        {{ $oferta->empleador->empleador->nombre_empresa ?? 'Empresa no especificada' }}
                                    </p>
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6 col-lg-3">
                                    <div class="p-3 border rounded bg-light">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                            <div>
                                                <small class="text-muted d-block">Ubicación</small>
                                                <strong>{{ $oferta->ubicacion }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="p-3 border rounded bg-light">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-money-bill-wave text-success me-2"></i>
                                            <div>
                                                <small class="text-muted d-block">Salario</small>
                                                <strong>{{ $oferta->salario ? number_format($oferta->salario, 2) . '€' : 'No especificado' }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="p-3 border rounded bg-light">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file-contract text-info me-2"></i>
                                            <div>
                                                <small class="text-muted d-block">Tipo de Contrato</small>
                                                <strong>{{ $oferta->tipo_contrato }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="p-3 border rounded bg-light">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-clock text-warning me-2"></i>
                                            <div>
                                                <small class="text-muted d-block">Publicado</small>
                                                <strong>{{ $oferta->created_at->diffForHumans() }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Descripción del puesto -->
                            <div class="mb-4">
                                <h5 class="border-bottom pb-2"><i class="fas fa-align-left me-2"></i>Descripción del puesto</h5>
                                <div class="mt-3">
                                    {!! nl2br(e($oferta->descripcion)) !!}
                                </div>
                            </div>

                            @if($oferta->fecha_inicio || $oferta->fecha_fin)
                            <div class="alert alert-info bg-light border-info">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar-alt text-info me-3 fa-2x"></i>
                                    <div>
                                        @if($oferta->fecha_inicio)
                                            <p class="mb-1">
                                                <strong>Fecha de inicio:</strong> 
                                                {{ $oferta->fecha_inicio instanceof \Carbon\Carbon ? $oferta->fecha_inicio->format('d/m/Y') : 'No especificada' }}
                                            </p>
                                        @endif
                                        @if($oferta->fecha_fin)
                                            <p class="mb-0">
                                                <strong>Fecha de finalización:</strong> 
                                                {{ $oferta->fecha_fin instanceof \Carbon\Carbon ? $oferta->fecha_fin->format('d/m/Y') : 'No especificada' }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Información de la empresa -->
                    <div class="card shadow-sm mb-4 border-0">
                        <div class="card-body">
                            <h5 class="card-title border-bottom pb-2">
                                <i class="fas fa-building me-2"></i>Sobre la empresa
                            </h5>
                            <p class="card-text">{{ $oferta->empleador->descripcion ?? 'No hay descripción disponible.' }}</p>
                            
                            <div class="row g-3 mt-3">
                                @if($oferta->empleador->sector)
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-industry text-secondary me-2"></i>
                                        <div>
                                            <small class="text-muted d-block">Sector</small>
                                            <strong>{{ $oferta->empleador->sector }}</strong>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($oferta->empleador->sitio_web)
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-globe text-primary me-2"></i>
                                        <div>
                                            <small class="text-muted d-block">Sitio web</small>
                                            <a href="{{ $oferta->empleador->sitio_web }}" target="_blank" class="text-decoration-none">
                                                {{ $oferta->empleador->sitio_web }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($oferta->empleador->ubicacion)
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-map-marked-alt text-danger me-2"></i>
                                        <div>
                                            <small class="text-muted d-block">Ubicación principal</small>
                                            <strong>{{ $oferta->empleador->ubicacion }}</strong>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Tarjeta de acción -->
                    <div class="card shadow-sm mb-4 border-0 sticky-top" style="top: 20px;">
                        <div class="card-body">
                            <h5 class="card-title mb-4 text-center">¿Te interesa esta oferta?</h5>
                            @php
                                $yaAplicado = auth()->user() && $oferta->aplicaciones->where('empleado_id', auth()->id())->count() > 0;
                            @endphp
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            @if(!$yaAplicado)
                                <form action="{{ route('empleado.aplicar', $oferta->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-lg w-100 mb-3 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-paper-plane me-2"></i>
                                        Aplicar ahora
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-info text-center mb-3">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Ya has aplicado a esta oferta.
                                </div>
                            @endif
                            <div class="text-center">
                                <small class="text-muted d-flex align-items-center justify-content-center">
                                    <i class="fas fa-shield-alt me-2"></i>
                                    Tu aplicación será tratada con confidencialidad
                                </small>
                            </div>

                            @if($oferta->empleador->beneficios)
                            <div class="mt-4">
                                <h6 class="mb-3">
                                    <i class="fas fa-gift text-success me-2"></i>
                                    Beneficios de la empresa
                                </h6>
                                <ul class="list-unstyled mb-0">
                                    @foreach(explode(',', $oferta->empleador->beneficios) as $beneficio)
                                    <li class="mb-2 d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        {{ trim($beneficio) }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
.sidebar {
    min-height: 100vh;
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
}

.sidebar .nav-link {
    color: #333;
    padding: .5rem 1rem;
    border-radius: .25rem;
    margin: .2rem 0;
}

.sidebar .nav-link:hover {
    background-color: rgba(0, 0, 0, .05);
}

.sidebar .nav-link.active {
    background-color: #007bff;
    color: white;
}

.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
}

.company-logo {
    transition: transform 0.3s ease;
}

.card:hover .company-logo {
    transform: scale(1.05);
}

.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

.breadcrumb {
    margin-bottom: 0;
}

.breadcrumb-item a {
    color: #6c757d;
    text-decoration: none;
}

.breadcrumb-item a:hover {
    color: #007bff;
}

.sticky-top {
    z-index: 1020;
}
</style>
@endsection 