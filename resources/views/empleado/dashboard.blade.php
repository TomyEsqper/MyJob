<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Empleado</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/empleado.css') }}">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-auto p-0 sidebar">
            <div class="logo d-flex align-items-center p-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" height="50" >
                    <!-- <span class="ms-2 fw-bold">Myjob</span> -->
                </div>
                <ul class="nav flex-column mt-4">
                    <li class="nav-item">
                        <a href="#" class="nav-link active">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-briefcase text-success"></i> Mis Aplicaciones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-search"></i> Buscar Empleos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-file-alt"></i> Mi CV
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-bell"></i> Notificaciones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('empleado.perfil') }}" class="nav-link">
                            <i class="fas fa-user"></i> Mi Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-cog"></i> Configuración
                        </a>
                    </li>
                    <li class="nav-item mt-5">
                        <form action="{{ route('logout') }}" method="POST" class="nav-link">
                            @csrf
                            <button type="submit" class="btn btn-link text-danger p-0">
                                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col main-content">
                <!-- Header -->
                <div class="header">
                    <h4 class="mb-0">Dashboard</h4>
                    <div class="user-profile">
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle text-decoration-none" data-bs-toggle="dropdown">
                                <i class="fas fa-bell text-muted"></i>
                                <span class="badge rounded-pill bg-danger">3</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Notificación 1</a></li>
                                <li><a class="dropdown-item" href="#">Notificación 2</a></li>
                                <li><a class="dropdown-item" href="#">Notificación 3</a></li>
                            </ul>
                        </div>
                        <div class="dropdown ms-3">
                            <a href="#" class="dropdown-toggle text-decoration-none d-flex align-items-center" data-bs-toggle="dropdown">
                                @auth
                                    <img src="{{ Auth::user()->foto_perfil }}" class="rounded-circle m-2" width="30">
                                    <span>¡Bienvenido {{ Auth::user()->nombre_usuario }}!</span>
                                @endauth
                                @guest
                                    <span>Invitado</span>
                                @endguest
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('empleado.perfil') }}">Mi Perfil</a></li>
                                <li><a class="dropdown-item" href="#">Configuración</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Cerrar Sesión</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Stats Row -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="icon">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <div class="content">
                                <h3>12</h3>
                                <p>Aplicaciones Enviadas</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <div class="content">
                                <h3>45</h3>
                                <p>Vistas de Perfil</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="content">
                                <h3>3</h3>
                                <p>Entrevistas Programadas</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Applications -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Aplicaciones Recientes</h5>
                        <a href="#" class="btn btn-sm btn-outline-light">Ver Todas</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="job-card">
                            <div class="company-logo">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="job-info">
                                <h4>Desarrollador Frontend</h4>
                                <p>TechSolutions Inc. • Madrid • Hace 2 días</p>
                            </div>
                            <div class="job-actions">
                                <span class="badge bg-success">Entrevista</span>
                            </div>
                        </div>
                        <div class="job-card">
                            <div class="company-logo">
                                <i class="fas fa-laptop-code"></i>
                            </div>
                            <div class="job-info">
                                <h4>Diseñador UX/UI</h4>
                                <p>Creative Studio • Barcelona • Hace 3 días</p>
                            </div>
                            <div class="job-actions">
                                <span class="badge bg-warning text-dark">En Revisión</span>
                            </div>
                        </div>
                        <div class="job-card">
                            <div class="company-logo">
                                <i class="fas fa-code"></i>
                            </div>
                            <div class="job-info">
                                <h4>Desarrollador Full Stack</h4>
                                <p>InnovaTech • Valencia • Hace 5 días</p>
                            </div>
                            <div class="job-actions">
                                <span class="badge bg-secondary">Enviada</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recommended Jobs -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Ofertas Disponibles</h5>
                        <a href="#" class="btn btn-sm btn-outline-light">Ver Más</a>
                    </div>
                    <div class="card-body p-0">
                        @forelse($ofertas as $oferta)
                        <div class="job-card p-4 border-bottom position-relative">
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
                                                <i class="fas fa-money-bill-wave me-1 text-success"></i>
                                                {{ $oferta->salario ? number_format($oferta->salario, 2) . '€' : 'Salario no especificado' }}
                                            </span>
                                            <span class="text-muted small">
                                                <i class="fas fa-clock me-1 text-info"></i>
                                                {{ $oferta->tipo_contrato }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-auto mt-3 mt-md-0">
                                    <div class="job-actions d-flex gap-2 justify-content-md-end">
                                        <a href="{{ route('empleador.ofertas.show', ['oferta' => $oferta->id]) }}" 
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye me-1"></i> Ver Detalle
                                        </a>
                                        <form action="{{ route('empleado.aplicar', $oferta->id) }}" method="POST">
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
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-briefcase fa-3x mb-3 text-light"></i>
                            <p class="mb-0">No hay ofertas disponibles en este momento.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .job-card {
            transition: all 0.3s ease;
            background-color: white;
        }
        .job-card:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .company-logo {
            transition: all 0.3s ease;
        }
        .job-card:hover .company-logo {
            transform: scale(1.05);
        }
        .btn {
            transition: all 0.2s ease;
        }
        .btn:hover {
            transform: translateY(-1px);
        }
        .gap-3 {
            gap: 1rem !important;
        }
        .gap-2 {
            gap: 0.5rem !important;
        }
    </style>
</body>
</html>
