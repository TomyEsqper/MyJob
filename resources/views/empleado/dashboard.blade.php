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
                <div class="logo">
                    <img src="{{ asset('logos/mac-os-100.png') }}" alt="Logo" height="50">
                    <span class="ms-2 fw-bold">JobPortal</span>
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
                        <a href="#" class="nav-link">
                            <i class="fas fa-cog"></i> Configuración
                        </a>
                    </li>
                    <li class="nav-item mt-5">
                        <a href="#" class="nav-link text-danger">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </a>
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
                                    <img src="{{ Auth::user()->foto_perfil }}" class="rounded-circle m-2" width="30" alt="ImgGoogle">
                                    <span>¡Bienvenido {{ Auth::user()->nombre_usuario }}!</span>
                                @endauth
                                @guest
                                    <span>Invitado</span>
                                @endguest
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Mi Perfil</a></li>
                                <li><a class="dropdown-item" href="#">Configuración</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#">Cerrar Sesión</a></li>
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
                        <div class="job-card">
                            <div class="company-logo">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="job-info">
                                <h4>{{ $oferta->titulo }}</h4>
                                <p>{{ $oferta->empresa ?? 'Empresa desconocida' }} • {{ $oferta->ubicacion }} • {{ $oferta->salario ? number_format($oferta->salario, 2) . '€' : 'Salario no especificado' }}</p>
                            </div>
                            <div class="job-actions">
                                <a href="{{ route('ofertas.show', $oferta->id) }}" class="btn btn-sm btn-primary">Ver Detalle</a>
                                <form action="{{ route('aplicaciones.store', $oferta->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Aplicar</button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <div class="p-3 text-center text-muted">No hay ofertas disponibles en este momento.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
