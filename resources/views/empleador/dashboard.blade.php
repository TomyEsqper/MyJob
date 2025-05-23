<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Empleador</title>
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
                    <img src="{{ asset('logos/mac-os-100.png') }}" alt="Logo" height="50">
                    <span class="ms-2 fw-bold">JobPortal</span>
                </div>
                <ul class="nav flex-column mt-4 px-2">
                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link active rounded">
                            <i class="fas fa-home me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="#" class="nav-link rounded">
                            <i class="fas fa-briefcase me-2"></i> Mis Ofertas
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
                        <a href="#" class="nav-link text-danger rounded">
                            <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col main-content">               <!-- Header -->
                <div class="header mb-4 rounded shadow-sm">
                    <h4 class="mb-0 fw-bold">Dashboard Empleador</h4>
                    <div class="user-profile">
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
                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Bienvenida -->
                <div class="welcome-section bg-white p-4 rounded shadow-sm mb-4">
                    <h2 class="fw-bold">¡Bienvenido de nuevo!</h2>
                    <p class="text-muted mb-0">Aquí tienes un resumen de tu actividad reciente y estadísticas.</p>
                </div>

                <!-- Stats Row -->
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="stat-card bg-white rounded shadow-sm p-4">
                            <div class="d-flex align-items-center">
                                <div class="icon me-3">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <div class="content">
                                    <h3 class="mb-1 fw-bold">8</h3>
                                    <p class="mb-0 text-muted">Ofertas Activas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card bg-white rounded shadow-sm p-4">
                            <div class="d-flex align-items-center">
                                <div class="icon me-3">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="content">
                                    <h3 class="mb-1 fw-bold">124</h3>
                                    <p class="mb-0 text-muted">Candidatos Totales</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card bg-white rounded shadow-sm p-4">
                            <div class="d-flex align-items-center">
                                <div class="icon me-3">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div class="content">
                                    <h3 class="mb-1 fw-bold">1,458</h3>
                                    <p class="mb-0 text-muted">Vistas de Ofertas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card bg-white rounded shadow-sm p-4">
                            <div class="d-flex align-items-center">
                                <div class="icon me-3">
                                    <i class="fas fa-handshake"></i>
                                </div>
                                <div class="content">
                                    <h3 class="mb-1 fw-bold">12</h3>
                                    <p class="mb-0 text-muted">Contrataciones</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Sections -->
                <div class="row">
                    <!-- Recent Applications -->
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm rounded">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                                <h5 class="mb-0 fw-bold"><i class="fas fa-users me-2 text-primary"></i>Candidatos Recientes</h5>
                                <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3">Ver Todos</a>
                            </div>
                            <div class="card-body p-0">
                                <div class="user-card d-flex align-items-center p-3 border-bottom">
                                    <div class="user-avatar bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                    <div class="user-info flex-grow-1">
                                        <h5 class="mb-1 fw-medium">Juan Pérez</h5>
                                        <p class="mb-0 text-muted small"><i class="fas fa-code me-1"></i>Desarrollador Frontend • <i class="fas fa-briefcase me-1"></i>5 años exp. • <i class="fas fa-map-marker-alt me-1"></i>Madrid</p>
                                    </div>
                                    <div class="user-actions">
                                        <button class="btn btn-sm btn-outline-primary me-2 rounded-pill"><i class="fas fa-file-alt me-1"></i>Ver CV</button>
                                        <button class="btn btn-sm btn-primary rounded-pill"><i class="fas fa-envelope me-1"></i>Contactar</button>
                                    </div>
                                </div>
                                <div class="user-card d-flex align-items-center p-3 border-bottom">
                                    <div class="user-avatar bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                    <div class="user-info flex-grow-1">
                                        <h5 class="mb-1 fw-medium">María García</h5>
                                        <p class="mb-0 text-muted small"><i class="fas fa-paint-brush me-1"></i>Diseñadora UX/UI • <i class="fas fa-briefcase me-1"></i>3 años exp. • <i class="fas fa-map-marker-alt me-1"></i>Barcelona</p>
                                    </div>
                                    <div class="user-actions">
                                        <button class="btn btn-sm btn-outline-primary me-2 rounded-pill"><i class="fas fa-file-alt me-1"></i>Ver CV</button>
                                        <button class="btn btn-sm btn-primary rounded-pill"><i class="fas fa-envelope me-1"></i>Contactar</button>
                                    </div>
                                </div>
                                <div class="user-card d-flex align-items-center p-3">
                                    <div class="user-avatar bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                    <div class="user-info flex-grow-1">
                                        <h5 class="mb-1 fw-medium">Carlos Rodríguez</h5>
                                        <p class="mb-0 text-muted small"><i class="fas fa-laptop-code me-1"></i>Desarrollador Full Stack • <i class="fas fa-briefcase me-1"></i>7 años exp. • <i class="fas fa-globe me-1"></i>Remoto</p>
                                    </div>
                                    <div class="user-actions">
                                        <button class="btn btn-sm btn-outline-primary me-2 rounded-pill"><i class="fas fa-file-alt me-1"></i>Ver CV</button>
                                        <button class="btn btn-sm btn-primary rounded-pill"><i class="fas fa-envelope me-1"></i>Contactar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Active Job Listings -->
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm rounded">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                                <h5 class="mb-0 fw-bold"><i class="fas fa-briefcase me-2 text-primary"></i>Ofertas Activas</h5>
                                <button class="btn btn-sm btn-primary rounded-pill px-3"><i class="fas fa-plus me-1"></i>Nueva Oferta</button>
                            </div>
                            <div class="card-body p-0">
                                <div class="job-card d-flex align-items-center p-3 border-bottom">
                                    <div class="company-logo bg-light rounded d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                        <i class="fas fa-code text-primary"></i>
                                    </div>
                                    <div class="job-info flex-grow-1">
                                        <h5 class="mb-1 fw-medium">Desarrollador Frontend</h5>
                                        <p class="mb-0 text-muted small"><i class="fas fa-map-marker-alt me-1"></i>Madrid • <i class="fas fa-euro-sign me-1"></i>45.000€ - 55.000€ • <i class="fas fa-users me-1"></i>28 aplicaciones</p>
                                    </div>
                                    <div class="job-actions">
                                        <button class="btn btn-sm btn-outline-primary me-2 rounded-pill"><i class="fas fa-edit me-1"></i>Editar</button>
                                        <button class="btn btn-sm btn-outline-danger rounded-pill"><i class="fas fa-pause me-1"></i>Pausar</button>
                                    </div>
                                </div>
                                <div class="job-card d-flex align-items-center p-3 border-bottom">
                                    <div class="company-logo bg-light rounded d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                        <i class="fas fa-laptop-code text-primary"></i>
                                    </div>
                                    <div class="job-info flex-grow-1">
                                        <h5 class="mb-1 fw-medium">Diseñador UX/UI</h5>
                                        <p class="mb-0 text-muted small"><i class="fas fa-map-marker-alt me-1"></i>Barcelona • <i class="fas fa-euro-sign me-1"></i>40.000€ - 50.000€ • <i class="fas fa-users me-1"></i>15 aplicaciones</p>
                                    </div>
                                    <div class="job-actions">
                                        <button class="btn btn-sm btn-outline-primary me-2 rounded-pill"><i class="fas fa-edit me-1"></i>Editar</button>
                                        <button class="btn btn-sm btn-outline-danger rounded-pill"><i class="fas fa-pause me-1"></i>Pausar</button>
                                    </div>
                                </div>
                                <div class="job-card d-flex align-items-center p-3">
                                    <div class="company-logo bg-light rounded d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                        <i class="fas fa-database text-primary"></i>
                                    </div>
                                    <div class="job-info flex-grow-1">
                                        <h5 class="mb-1 fw-medium">Ingeniero de Datos</h5>
                                        <p class="mb-0 text-muted small"><i class="fas fa-map-marker-alt me-1"></i>Madrid • <i class="fas fa-euro-sign me-1"></i>60.000€ - 75.000€ • <i class="fas fa-users me-1"></i>8 aplicaciones</p>
                                    </div>
                                    <div class="job-actions">
                                        <button class="btn btn-sm btn-outline-primary me-2 rounded-pill"><i class="fas fa-edit me-1"></i>Editar</button>
                                        <button class="btn btn-sm btn-outline-danger rounded-pill"><i class="fas fa-pause me-1"></i>Pausar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>