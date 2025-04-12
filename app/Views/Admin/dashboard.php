<?php
session_start();
require_once '../../../Config/db.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../Auth/login.php');
    exit();
}

// Verificar si el usuario tiene el rol de administrador y el correo correcto
$stmt = $conexion->prepare("SELECT correo_electronico FROM usuarios WHERE id_usuario = ?");
$stmt->bind_param("i", $_SESSION['id_usuario']);
$stmt->execute();
$result = $stmt->get_result();
$usuario_data = $result->fetch_assoc();
$correo_usuario = $usuario_data['correo_electronico'];

// Verificar si el usuario tiene el rol de administrador y su correo termina con @myjob.com
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin' || substr(strtolower($correo_usuario), -10) !== '@myjob.com') {
    // Redirigir según el rol del usuario
    if (isset($_SESSION['rol']) && $_SESSION['rol'] != 'admin') {
        switch ($_SESSION['rol']) {
            case 'empleado':
                header('Location: ../Empleado/dashboard.php');
                break;
            case 'empleador':
                header('Location: ../Empleador/dashboard.php');
                break;
            default:
                header('Location: ../Auth/login.php');
        }
    } else {
        header('Location: ../Auth/login.php');
    }
    exit();
}

// Obtener información del usuario
$id_usuario = $_SESSION['id_usuario'];
$stmt = $conexion->prepare("SELECT nombre_usuario FROM usuarios WHERE id_usuario = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$nombre_usuario = $usuario['nombre_usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrador - MyJob</title>
    <link rel="stylesheet" media="all" href="../../Assets/CSS/styles.css">
    <link rel="stylesheet" media="all" href="../../Assets/CSS/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-DQvkBjpPgn7RC31MCQoOeC9TI2kdqa4+BSgNMNj8v77fdC77Kj5zpWFTJaaAoMbC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-YUe2LzesAfftltw+PEaao2tjU/QATaW/rOitAq67e0CT0Zi2VVRL0oC4+gAaeBKu" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>  
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <h3 class="mb-3">My<span style="color: #258d19;">Job</span></h3>
            <div class="welcome-container" style="background: linear-gradient(to right, #f8f9fa, #e9f5ec); padding: 12px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <p class="text-center mb-1" style="font-size: 15px; font-family: 'Segoe UI', sans-serif; letter-spacing: 0.5px;">Bienvenido</p>
                <p class="text-center" style="font-size: 18px; font-weight: 600; color: #258d19; text-shadow: 0px 0px 1px rgba(0,0,0,0.1);"><?php echo $nombre_usuario; ?></p>
            </div>
        </div>
        <div class="mt-4">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <i class="bi bi-house-door"></i> Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-people"></i> Usuarios
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-briefcase"></i> Ofertas de Empleo
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-building"></i> Empresas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-graph-up"></i> Estadísticas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-flag"></i> Reportes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-bell"></i> Notificaciones
                    </a>
                </li>
                <li class="nav-item mt-5">
                    <a class="nav-link" href="#">
                        <i class="bi bi-gear"></i> Configuración
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="../../Controllers/Auth/logoutController.php">
                        <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <h4>Dashboard de Administrador</h4>
            <div class="user-profile">
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i> Administrador
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Ver Perfil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Configuración</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="../../Controllers/Auth/logoutController.php"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="content">
                        <h3>245</h3>
                        <p>Usuarios Totales</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="bi bi-briefcase"></i>
                    </div>
                    <div class="content">
                        <h3>87</h3>
                        <p>Ofertas Activas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <div class="content">
                        <h3>42</h3>
                        <p>Empresas Registradas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="content">
                        <h3>156</h3>
                        <p>Contrataciones</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Rows -->
        <div class="row">
            <!-- Recent Users -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Usuarios Recientes</h5>
                        <button class="btn btn-sm btn-light"><i class="bi bi-plus"></i> Nuevo Usuario</button>
                    </div>
                    <div class="card-body p-0">
                        <div class="user-card">
                            <div class="user-avatar">
                                <i class="bi bi-person"></i>
                            </div>
                            <div class="user-info">
                                <h4>Ana Martínez</h4>
                                <p>Empleado - Registrado: 15/04/2023</p>
                            </div>
                            <div class="user-actions">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Acciones
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-eye"></i> Ver Perfil</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-pencil"></i> Editar</a></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash"></i> Eliminar</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="user-card">
                            <div class="user-avatar">
                                <i class="bi bi-person"></i>
                            </div>
                            <div class="user-info">
                                <h4>Carlos Rodríguez</h4>
                                <p>Empleador - Registrado: 12/04/2023</p>
                            </div>
                            <div class="user-actions">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Acciones
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-eye"></i> Ver Perfil</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-pencil"></i> Editar</a></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash"></i> Eliminar</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="user-card">
                            <div class="user-avatar">
                                <i class="bi bi-person"></i>
                            </div>
                            <div class="user-info">
                                <h4>Laura Sánchez</h4>
                                <p>Empleado - Registrado: 10/04/2023</p>
                            </div>
                            <div class="user-actions">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Acciones
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-eye"></i> Ver Perfil</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-pencil"></i> Editar</a></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash"></i> Eliminar</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="user-card">
                            <div class="user-avatar">
                                <i class="bi bi-person"></i>
                            </div>
                            <div class="user-info">
                                <h4>Miguel Ángel López</h4>
                                <p>Empleador - Registrado: 08/04/2023</p>
                            </div>
                            <div class="user-actions">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Acciones
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-eye"></i> Ver Perfil</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi bi-pencil"></i> Editar</a></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash"></i> Eliminar</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="#" class="btn btn-outline-primary btn-sm">Ver todos los usuarios</a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity & System Stats -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Actividad Reciente</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="bi bi-person-plus"></i>
                            </div>
                            <div class="activity-content">
                                <h5>Nuevo Usuario Registrado</h5>
                                <p>Ana Martínez se ha registrado como empleado.</p>
                            </div>
                            <div class="activity-time">
                                Hace 2 horas
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="bi bi-briefcase"></i>
                            </div>
                            <div class="activity-content">
                                <h5>Nueva Oferta de Empleo</h5>
                                <p>TechSolutions S.A. ha publicado una nueva oferta: Desarrollador Frontend.</p>
                            </div>
                            <div class="activity-time">
                                Hace 3 horas
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="activity-content">
                                <h5>Contratación Realizada</h5>
                                <p>Carlos Rodríguez ha contratado a Laura Sánchez para el puesto de Diseñador UX/UI.</p>
                            </div>
                            <div class="activity-time">
                                Hace 5 horas
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="bi bi-flag"></i>
                            </div>
                            <div class="activity-content">
                                <h5>Reporte de Oferta</h5>
                                <p>Se ha reportado una oferta por contenido inapropiado.</p>
                            </div>
                            <div class="activity-time">
                                Hace 1 día
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="#" class="btn btn-outline-primary btn-sm">Ver toda la actividad</a>
                    </div>
                </div>

                <!-- System Stats -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Estadísticas del Sistema</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Usuarios Empleados</span>
                                <span>65%</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Usuarios Empleadores</span>
                                <span>35%</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Tasa de Contratación</span>
                                <span>42%</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 42%;" aria-valuenow="42" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Uso del Sistema</span>
                                <span>78%</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 78%;" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Aquí puedes agregar cualquier JavaScript adicional que necesites
    </script>
</body>
</html>