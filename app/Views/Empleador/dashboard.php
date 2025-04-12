<?php
session_start();
require_once '../../../Config/db.php';

// Verificar si el usuario ha iniciado sesión y tiene el rol correcto
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../Auth/login.php');
    exit();
}

// Verificar si el usuario tiene el rol de empleador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'empleador') {
    // Redirigir según el rol del usuario
    if (isset($_SESSION['rol'])) {
        switch ($_SESSION['rol']) {
            case 'empleado':
                header('Location: ../Empleado/dashboard.php');
                break;
            case 'admin':
                header('Location: ../Admin/dashboard.php');
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
    <title>Dashboard Empleador - MyJob</title>
    <link rel="stylesheet" media="all" href="../../Assets/CSS/styles.css">
    <link rel="stylesheet" media="all" href="../../Assets/CSS/empleador.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-DQvkBjpPgn7RC31MCQoOeC9TI2kdqa4+BSgNMNj8v77fdC77Kj5zpWFTJaaAoMbC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-YUe2LzesAfftltw+PEaao2tjU/QATaW/rOitAq67e0CT0Zi2VVRL0oC4+gAaeBKu" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <h3>My<span style="color: #258d19;">Job</span></h3>
            <p class="text-center mb-0" style="font-size: 14px;">Bienvenido,</p>
            <p class="text-center" style="font-size: 16px; font-weight: bold; color: #258d19;"><?php echo $nombre_usuario; ?></p>
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
                        <i class="bi bi-briefcase"></i> Mis Ofertas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-plus-circle"></i> Publicar Oferta
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-people"></i> Candidatos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-building"></i> Mi Empresa
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-bell"></i> Notificaciones
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-chat"></i> Mensajes
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
            <h4>Dashboard de Empleador</h4>
            <div class="user-profile">
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i> Mi Perfil
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Ver Perfil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-building"></i> Perfil de Empresa</a></li>
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
                        <i class="bi bi-briefcase"></i>
                    </div>
                    <div class="content">
                        <h3>12</h3>
                        <p>Ofertas Activas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="content">
                        <h3>48</h3>
                        <p>Candidatos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="bi bi-eye"></i>
                    </div>
                    <div class="content">
                        <h3>156</h3>
                        <p>Vistas a Ofertas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="content">
                        <h3>5</h3>
                        <p>Contrataciones</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Rows -->
        <div class="row">
            <!-- Job Listings -->
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Mis Ofertas de Empleo</h5>
                        <button class="btn btn-sm btn-light"><i class="bi bi-plus"></i> Nueva Oferta</button>
                    </div>
                    <div class="card-body p-0">
                        <div class="job-listing">
                            <h5>Desarrollador Frontend Senior</h5>
                            <div class="job-meta">
                                <span><i class="bi bi-geo-alt"></i> Ciudad de México</span>
                                <span><i class="bi bi-clock"></i> Tiempo Completo</span>
                                <span><i class="bi bi-calendar"></i> Publicado: 15/04/2023</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div>
                                    <span class="badge badge-primary">React</span>
                                    <span class="badge badge-primary">JavaScript</span>
                                    <span class="badge badge-primary">CSS</span>
                                </div>
                                <span class="badge bg-success">18 candidatos</span>
                            </div>
                            <div class="job-actions">
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i> Editar</button>
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-people"></i> Ver Candidatos</button>
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Eliminar</button>
                            </div>
                        </div>
                        <div class="job-listing">
                            <h5>Diseñador UX/UI</h5>
                            <div class="job-meta">
                                <span><i class="bi bi-geo-alt"></i> Remoto</span>
                                <span><i class="bi bi-clock"></i> Tiempo Completo</span>
                                <span><i class="bi bi-calendar"></i> Publicado: 10/04/2023</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div>
                                    <span class="badge badge-primary">Figma</span>
                                    <span class="badge badge-primary">Adobe XD</span>
                                    <span class="badge badge-primary">Sketch</span>
                                </div>
                                <span class="badge bg-success">12 candidatos</span>
                            </div>
                            <div class="job-actions">
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i> Editar</button>
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-people"></i> Ver Candidatos</button>
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Eliminar</button>
                            </div>
                        </div>
                        <div class="job-listing">
                            <h5>Desarrollador Backend PHP</h5>
                            <div class="job-meta">
                                <span><i class="bi bi-geo-alt"></i> Guadalajara</span>
                                <span><i class="bi bi-clock"></i> Tiempo Completo</span>
                                <span><i class="bi bi-calendar"></i> Publicado: 05/04/2023</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div>
                                    <span class="badge badge-primary">PHP</span>
                                    <span class="badge badge-primary">MySQL</span>
                                    <span class="badge badge-primary">Laravel</span>
                                </div>
                                <span class="badge bg-success">9 candidatos</span>
                            </div>
                            <div class="job-actions">
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i> Editar</button>
                                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-people"></i> Ver Candidatos</button>
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Eliminar</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="#" class="btn btn-outline-primary btn-sm">Ver todas las ofertas</a>
                    </div>
                </div>
            </div>

            <!-- Recent Candidates -->
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Candidatos Recientes</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="candidate-card">
                            <div class="candidate-avatar">
                                <i class="bi bi-person"></i>
                            </div>
                            <div class="candidate-info">
                                <h4>Ana Martínez</h4>
                                <p>Desarrollador Frontend - 5 años exp.</p>
                                <small class="text-muted">Aplicó: Desarrollador Frontend Senior</small>
                            </div>
                            <div class="candidate-actions">
                                <button class="btn btn-sm btn-primary">Ver CV</button>
                            </div>
                        </div>
                        <div class="candidate-card">
                            <div class="candidate-avatar">
                                <i class="bi bi-person"></i>
                            </div>
                            <div class="candidate-info">
                                <h4>Carlos Rodríguez</h4>
                                <p>Diseñador UX/UI - 3 años exp.</p>
                                <small class="text-muted">Aplicó: Diseñador UX/UI</small>
                            </div>
                            <div class="candidate-actions">
                                <button class="btn btn-sm btn-primary">Ver CV</button>
                            </div>
                        </div>
                        <div class="candidate-card">
                            <div class="candidate-avatar">
                                <i class="bi bi-person"></i>
                            </div>
                            <div class="candidate-info">
                                <h4>Laura Sánchez</h4>
                                <p>Desarrollador Backend - 4 años exp.</p>
                                <small class="text-muted">Aplicó: Desarrollador Backend PHP</small>
                            </div>
                            <div class="candidate-actions">
                                <button class="btn btn-sm btn-primary">Ver CV</button>
                            </div>
                        </div>
                        <div class="candidate-card">
                            <div class="candidate-avatar">
                                <i class="bi bi-person"></i>
                            </div>
                            <div class="candidate-info">
                                <h4>Miguel Ángel López</h4>
                                <p>Desarrollador Frontend - 2 años exp.</p>
                                <small class="text-muted">Aplicó: Desarrollador Frontend Senior</small>
                            </div>
                            <div class="candidate-actions">
                                <button class="btn btn-sm btn-primary">Ver CV</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="#" class="btn btn-outline-primary btn-sm">Ver todos los candidatos</a>
                    </div>
                </div>

                <!-- Company Profile Completion -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Perfil de Empresa</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mt-2">Perfil de empresa completo al 85%</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-check-circle-fill text-success"></i> Información Básica</span>
                                <span class="badge bg-success rounded-pill">Completo</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-check-circle-fill text-success"></i> Logo y Fotos</span>
                                <span class="badge bg-success rounded-pill">Completo</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-check-circle-fill text-success"></i> Descripción</span>
                                <span class="badge bg-success rounded-pill">Completo</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-exclamation-circle text-warning"></i> Redes Sociales</span>
                                <span class="badge bg-warning rounded-pill">Pendiente</span>
                            </li>
                        </ul>
                        <div class="text-center mt-3">
                            <a href="#" class="btn btn-primary btn-sm">Completar Perfil</a>
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