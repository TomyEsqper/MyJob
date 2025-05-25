<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Oferta</title>
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
                    <!--<span class="ms-2 fw-bold">JobPortal</span>-->
                </div>
                <ul class="nav flex-column mt-4 px-2">
                    <li class="nav-item mb-2">
                        <a href="/empleador/dashboard" class="nav-link rounded">
                            <i class="fas fa-home me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('ofertas.index') }}" class="nav-link rounded">
                            <i class="fas fa-briefcase me-2 text-success"></i> Mis Ofertas
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
                    <h4 class="mb-0 fw-bold">Editar Oferta</h4>
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
                            <form id="logout-form-dropdown" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Edit Offer Form -->
                <div class="container">
                    <form action="{{ route('ofertas.update', $oferta->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo', $oferta->titulo) }}" required>
                            @error('titulo')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" required>{{ old('descripcion', $oferta->descripcion) }}</textarea>
                            @error('descripcion')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="ubicacion" class="form-label">Ubicación</label>
                            <input type="text" name="ubicacion" id="ubicacion" class="form-control" value="{{ old('ubicacion', $oferta->ubicacion) }}" required>
                            @error('ubicacion')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="salario" class="form-label">Salario</label>
                            <input type="number" step="0.01" name="salario" id="salario" class="form-control" value="{{ old('salario', $oferta->salario) }}">
                            @error('salario')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="tipo_contrato" class="form-label">Tipo de Contrato</label>
                            <input type="text" name="tipo_contrato" id="tipo_contrato" class="form-control" value="{{ old('tipo_contrato', $oferta->tipo_contrato) }}" required>
                            @error('tipo_contrato')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio', $oferta->fecha_inicio) }}">
                            @error('fecha_inicio')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ old('fecha_fin', $oferta->fecha_fin) }}">
                            @error('fecha_fin')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-success">Actualizar Oferta</button>
                        <a href="{{ route('ofertas.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>