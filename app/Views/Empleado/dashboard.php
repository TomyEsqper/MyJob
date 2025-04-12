<?php
session_start();
require_once '../../../Config/db.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../Auth/login.php');
    exit();
}

// Verificar si el usuario tiene el rol de empleado
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'empleado') {
    // Redirigir según el rol del usuario
    if (isset($_SESSION['rol'])) {
        switch ($_SESSION['rol']) {
            case 'empleador':
                header('Location: ../Empleador/dashboard.php');
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
    <title>Dashboard Empleado - MyJob</title>
    <link rel="stylesheet" media="all" href="../../Assets/CSS/styles.css">
    <link rel="stylesheet" media="all" href="../../Assets/CSS/empleado.css">
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
                        <i class="bi bi-briefcase"></i> Ofertas de Empleo
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-file-earmark-text"></i> Mi Currículum
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-bookmark"></i> Postulaciones
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
            <h4>Dashboard de Empleado</h4>
            <div class="user-profile">
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i> Mi Perfil
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
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="icon">
                        <i class="bi bi-briefcase"></i>
                    </div>
                    <div class="content">
                        <h3>24</h3>
                        <p>Ofertas Disponibles</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="icon">
                        <i class="bi bi-send"></i>
                    </div>
                    <div class="content">
                        <h3>8</h3>
                        <p>Postulaciones Activas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="icon">
                        <i class="bi bi-eye"></i>
                    </div>
                    <div class="content">
                        <h3>15</h3>
                        <p>Vistas a tu Perfil</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Rows -->
        <div class="row">
            <!-- Recent Job Listings -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Ofertas de Empleo Recomendadas</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="job-card">
                            <div class="company-logo">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="job-info">
                                <h4>Desarrollador Frontend</h4>
                                <p>TechSolutions S.A. - Ciudad de México</p>
                                <div>
                                    <span class="badge badge-primary">React</span>
                                    <span class="badge badge-primary">JavaScript</span>
                                    <span class="badge badge-primary">CSS</span>
                                </div>
                            </div>
                            <div class="job-actions">
                                <button class="btn btn-sm btn-primary">Postular</button>
                            </div>
                        </div>
                        <div class="job-card">
                            <div class="company-logo">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="job-info">
                                <h4>Desarrollador Backend PHP</h4>
                                <p>Innovatech - Guadalajara</p>
                                <div>
                                    <span class="badge badge-primary">PHP</span>
                                    <span class="badge badge-primary">MySQL</span>
                                    <span class="badge badge-primary">Laravel</span>
                                </div>
                            </div>
                            <div class="job-actions">
                                <button class="btn btn-sm btn-primary">Postular</button>
                            </div>
                        </div>
                        <div class="job-card">
                            <div class="company-logo">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="job-info">
                                <h4>Diseñador UX/UI</h4>
                                <p>CreativeDesign - Monterrey</p>
                                <div>
                                    <span class="badge badge-primary">Figma</span>
                                    <span class="badge badge-primary">Adobe XD</span>
                                    <span class="badge badge-primary">Sketch</span>
                                </div>
                            </div>
                            <div class="job-actions">
                                <button class="btn btn-sm btn-primary">Postular</button>
                            </div>
                        </div>
                        <div class="job-card">
                            <div class="company-logo">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="job-info">
                                <h4>Analista de Datos</h4>
                                <p>DataInsights - Ciudad de México</p>
                                <div>
                                    <span class="badge badge-primary">Python</span>
                                    <span class="badge badge-primary">SQL</span>
                                    <span class="badge badge-primary">Power BI</span>
                                </div>
                            </div>
                            <div class="job-actions">
                                <button class="btn btn-sm btn-primary">Postular</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="#" class="btn btn-outline-primary btn-sm">Ver todas las ofertas</a>
                    </div>
                </div>
            </div>

            <!-- Profile Completion & Recent Applications -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Completar Perfil</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mt-2">Tu perfil está completo al 75%</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-check-circle-fill text-success"></i> Información Personal</span>
                                <span class="badge bg-success rounded-pill">Completo</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-check-circle-fill text-success"></i> Experiencia Laboral</span>
                                <span class="badge bg-success rounded-pill">Completo</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-check-circle-fill text-success"></i> Educación</span>
                                <span class="badge bg-success rounded-pill">Completo</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-exclamation-circle text-warning"></i> Habilidades</span>
                                <span class="badge bg-warning rounded-pill">Pendiente</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-x-circle text-danger"></i> Certificaciones</span>
                                <span class="badge bg-danger rounded-pill">Pendiente</span>
                            </li>
                        </ul>
                        <div class="text-center mt-3">
                            <a href="#" class="btn btn-primary btn-sm">Completar Perfil</a>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Últimas Postulaciones</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Desarrollador Web</h6>
                                        <small class="text-muted">TechSolutions S.A.</small>
                                    </div>
                                    <span class="badge bg-info">En revisión</span>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Diseñador Gráfico</h6>
                                        <small class="text-muted">CreativeDesign</small>
                                    </div>
                                    <span class="badge bg-success">Entrevista</span>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Analista de Marketing</h6>
                                        <small class="text-muted">MarketPro</small>
                                    </div>
                                    <span class="badge bg-danger">Rechazado</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <a href="#" class="btn btn-outline-primary btn-sm">Ver todas las postulaciones</a>
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