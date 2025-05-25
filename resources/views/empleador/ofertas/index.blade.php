<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Ofertas de Trabajo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/empleador.css') }}">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-auto p-0 sidebar">
                <div class="logo d-flex align-items-center p-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" height="50" >
                    <!-- <span class="ms-2 fw-bold">JobPortal</span> -->
                </div>
                <ul class="nav flex-column mt-4 px-2">
                    <li class="nav-item mb-2">
                        <a href="/empleador/dashboard" class="nav-link rounded">
                            <i class="fas fa-home me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('ofertas.index') }}" class="nav-link rounded">
                            <i class="fas fa-briefcase fa-2x text-success me-2"></i> Mis Ofertas
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link rounded">
                            <i class="fas fa-users me-2"></i> Candidatos
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link rounded">
                            <i class="fas fa-building me-2"></i> Mi Empresa
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link rounded">
                            <i class="fas fa-chart-line me-2"></i> Estadísticas
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link rounded">
                            <i class="fas fa-bell me-2"></i> Notificaciones
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link rounded">
                            <i class="fas fa-cog me-2"></i> Configuración
                        </a>
                    </li>
                    <li class="nav-item mt-5">
                        <a href="{{ route('logout') }}" class="nav-link text-danger rounded"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
            <!-- Main Content -->
            <div class="col main-content">
                <!-- Header -->
                <div class="header mb-4 rounded shadow-sm d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold">Mis Ofertas de Trabajo</h4>
                    <div class="user-profile d-flex align-items-center">
                        <div class="dropdown me-3">
                            <a href="#" class="dropdown-toggle text-decoration-none position-relative" data-bs-toggle="dropdown">
                                <i class="fas fa-bell fs-5 text-muted"></i>
                                <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle">5</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                <li><h6 class="dropdown-header">Notificaciones recientes</h6></li>
                                <li><a class="dropdown-item" href="#">Nuevo candidato para Desarrollador Frontend</a></li>
                                <li><a class="dropdown-item" href="#">Nuevo candidato para Diseñador UX/UI</a></li>
                                <li><a class="dropdown-item" href="#">Oferta a punto de expirar</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-primary" href="#">Ver todas</a></li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle text-decoration-none d-flex align-items-center" data-bs-toggle="dropdown">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <span>TS</span>
                                </div>
                                <span class="ms-2 fw-medium">TechSolutions Inc.</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-building me-2 text-muted"></i>Perfil de Empresa</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2 text-muted"></i>Configuración</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-dropdown').submit();"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></li>
                            </ul>
                        </div>
                        <form id="logout-form-dropdown" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
                <!-- Offers Table -->
                <div class="container">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-briefcase fa-2x text-primary me-2"></i>
                        <h2 class="fw-bold mb-0">Ofertas Activas</h2>
                        <a href="{{ route('ofertas.create') }}" class="btn btn-success ms-auto">+ Nueva Oferta</a>
                    </div>
                    @foreach ($ofertas as $oferta)
                    <div class="card mb-3 shadow-sm border-0">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <span class="bg-light p-3 rounded-circle d-inline-block">
                                    <i class="fas fa-briefcase fa-lg text-success"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <h4 class="fw-bold mb-1 text-uppercase">{{ $oferta->titulo }}</h4>
                                <div class="text-muted small mb-1">
                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $oferta->ubicacion }}
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-money-bill-wave me-1"></i> {{ number_format($oferta->salario, 2) }}
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-file-contract me-1"></i> {{ $oferta->tipo_contrato }}
                                </div>
                                <div class="text-muted small">{{ $oferta->descripcion }}</div>
                            </div>
                            <div class="ms-3 d-flex flex-column align-items-end">
                                <a href="{{ route('ofertas.edit', $oferta->id) }}" class="btn btn-outline-success mb-2 px-3">
                                    <i class="fas fa-edit me-1"></i> Editar
                                </a>
                                <form action="{{ route('ofertas.destroy', $oferta->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta oferta?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-success px-3">
                                        <i class="fas fa-trash-alt me-1"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>