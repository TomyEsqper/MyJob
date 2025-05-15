<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrador</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
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
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-users"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-building"></i> Empresas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-briefcase"></i> Ofertas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-chart-bar"></i> Estadísticas
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
                    <h4 class="mb-0">Panel de Administración</h4>
                    <div class="user-profile">
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle text-decoration-none" data-bs-toggle="dropdown">
                                <i class="fas fa-bell text-muted"></i>
                                <span class="badge rounded-pill bg-danger">7</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Nueva empresa registrada</a></li>
                                <li><a class="dropdown-item" href="#">Reporte de oferta inapropiada</a></li>
                                <li><a class="dropdown-item" href="#">Actualización del sistema disponible</a></li>
                            </ul>
                        </div>
                        <div class="dropdown ms-3">
                            <a href="#" class="dropdown-toggle text-decoration-none d-flex align-items-center" data-bs-toggle="dropdown">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <span>AD</span>
                                </div>
                                <span class="ms-2">Admin</span>
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
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="content">
                                <h3>1,245</h3>
                                <p>Usuarios Totales</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="content">
                                <h3>87</h3>
                                <p>Empresas Activas</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="content">
                                <h3>342</h3>
                                <p>Ofertas Publicadas</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="icon">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <div class="content">
                                <h3>156</h3>
                                <p>Contrataciones</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Users -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Usuarios Recientes</h5>
                        <a href="#" class="btn btn-sm btn-outline-light">Ver Todos</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="user-card">
                            <div class="user-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="user-info">
                                <h4>Juan Pérez</h4>
                                <p>Empleado • Registrado hace 2 días • Madrid</p>
                            </div>
                            <div class="user-actions">
                                <button class="btn btn-sm btn-outline-primary me-2">Ver Perfil</button>
                                <button class="btn btn-sm btn-outline-danger">Suspender</button>
                            </div>
                        </div>
                        <div class="user-card">
                            <div class="user-avatar">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="user-info">
                                <h4>TechSolutions Inc.</h4>
                                <p>Empleador • Registrado hace 3 días • Barcelona</p>
                            </div>
                            <div class="user-actions">
                                <button class="btn btn-sm btn-outline-primary me-2">Ver Perfil</button>
                                <button class="btn btn-sm btn-outline-danger">Suspender</button>
                            </div>
                        </div>
                        <div class="user-card">
                            <div class="user-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="user-info">
                                <h4>María García</h4>
                                <p>Empleado • Registrado hace 5 días • Valencia</p>
                            </div>
                            <div class="user-actions">
                                <button class="btn btn-sm btn-outline-primary me-2">Ver Perfil</button>
                                <button class="btn btn-sm btn-outline-danger">Suspender</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Overview -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Reportes Recientes</h5>
                                <a href="#" class="btn btn-sm btn-outline-light">Ver Todos</a>
                            </div>
                            <div class="card-body p-0">
                                <div class="user-card">
                                    <div class="user-avatar bg-warning text-dark">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div class="user-info">
                                        <h4>Oferta Inapropiada</h4>
                                        <p>Reportado por: Carlos Rodríguez • Hace 1 día</p>
                                    </div>
                                    <div class="user-actions">
                                        <button class="btn btn-sm btn-outline-primary">Revisar</button>
                                    </div>
                                </div>
                                <div class="user-card">
                                    <div class="user-avatar bg-warning text-dark">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div class="user-info">
                                        <h4>Perfil Falso</h4>
                                        <p>Reportado por: TechSolutions Inc. • Hace 2 días</p>
                                    </div>
                                    <div class="user-actions">
                                        <button class="btn btn-sm btn-outline-primary">Revisar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Estado del Sistema</h5>
                                <a href="#" class="btn btn-sm btn-outline-light">Detalles</a>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <p class="mb-1 d-flex justify-content-between">
                                        <span>Categorías Populares</span>
                                        <span><i class="fas fa-chart-pie text-primary"></i></span>
                                    </p>
                                    <div class="d-flex justify-content-between small text-muted mb-1">
                                        <span>Tecnología (35%)</span>
                                        <span>Marketing (25%)</span>
                                        <span>Ventas (20%)</span>
                                        <span>Otros (20%)</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <p class="mb-1"><i class="fas fa-info-circle text-info me-2"></i> Última actualización: Hoy, 10:45 AM</p>
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