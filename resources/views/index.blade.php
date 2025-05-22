<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Job - Conectando Talento Local</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <!-- Add after your existing links -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="loading-screen">
        <img src="{{ asset('images/logo.png') }}" alt="Loading..." class="loading-logo">
    </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo2.png') }}" alt="My Job" class="nav-logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#inicio">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#funciones">Funciones</a></li>
                    <li class="nav-item"><a class="nav-link" href="#nosotros">Sobre Nosotros</a></li>
                    <li class="nav-item"><a class="nav-link" href="#creadores">Creadores</a></li>
                    <li class="nav-item"><a class="btn btn-light me-2" href="{{ route('login') }}">Iniciar Sesión</a></li>
                    <li class="nav-item"><a class="btn btn-outline-success" href="{{ route('register') }}">Registrarse</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section" id="inicio">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 mb-4">Bienvenido a My Job</h1>
                    <p class="lead mb-4">
                        Una plataforma web diseñada para conectar de forma rápida y eficiente a personas que buscan trabajo con empleadores que necesitan talento local.
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="#" class="btn btn-primary btn-lg">Buscar Empleo</a>
                        <a href="#" class="btn btn-outline-primary btn-lg">Publicar Ofertas</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding" id="funciones">
        <div class="container">
            <h2 class="text-center mb-5">¿Qué puedes hacer en My Job?</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <i class="fas fa-search feature-icon"></i>
                        <h3>Buscar empleo</h3>
                        <p>Explora las ofertas laborales disponibles en tu zona y postúlate fácilmente con tu perfil.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <i class="fas fa-bullhorn feature-icon"></i>
                        <h3>Publicar ofertas</h3>
                        <p>Si eres empleador, publica vacantes en minutos y encuentra candidatos según sus habilidades.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <i class="fas fa-sync feature-icon"></i>
                        <h3>Emparejamiento</h3>
                        <p>Sistema inteligente que cruza información para mostrar las mejores coincidencias.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <i class="fas fa-mobile-alt feature-icon"></i>
                        <h3>Multiplataforma</h3>
                        <p>Accede desde cualquier dispositivo: celular, tablet o PC.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding bg-light" id="nosotros">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="mb-4">Sobre Nosotros</h2>
                    <p class="mb-4">
                        Somos un grupo de jóvenes desarrolladores apasionados por la tecnología y el impacto social. Este proyecto nació con el objetivo de resolver una necesidad real: hacer más fácil la conexión entre personas que necesitan empleo y quienes necesitan contratar sin procesos largos y complicados.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <h2 class="text-center mb-5">Funciones principales</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Registro e inicio de sesión</h5>
                            <p class="card-text">Como empleado o empleador</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Perfiles personalizados</h5>
                            <p class="card-text">Crea tu perfil profesional</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Sistema inteligente</h5>
                            <p class="card-text">Coincidencias entre oferta y demanda laboral</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding bg-light" id="creadores">
        <div class="container">
            <h2 class="text-center mb-5 animate-on-scroll">Nuestro Equipo Creador</h2>
            <div class="row justify-content-center g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="creator-card animate-on-scroll">
                        <img src="{{ asset('images/cuervo.jpg') }}" alt="Camilo Cuervo" class="creator-image">
                        <h3>Camilo Cuervo</h3>
                        <p class="text-muted">Desarrollador Full Stack</p>
                        <p>Especialista en desarrollo web y arquitectura de software. Líder técnico del proyecto.</p>
                        <div class="social-links">
                            <a href="#" target="_blank"><i class="fab fa-github"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="creator-card animate-on-scroll">
                        <img src="{{ asset('images/tomas.jpg') }}" alt="Tomás Esquivel" class="creator-image">
                        <h3>Tomás Esquivel</h3>
                        <p class="text-muted">Frontend Developer</p>
                        <p>Experto en interfaces de usuario y experiencia de usuario. Responsable del diseño visual.</p>
                        <div class="social-links">
                            <a href="#" target="_blank"><i class="fab fa-github"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="creator-card animate-on-scroll">
                        <img src="{{ asset('images/nicolas.jpg') }}" alt="Nicolás Plazas" class="creator-image">
                        <h3>Nicolás Plazas</h3>
                        <p class="text-muted">Backend Developer</p>
                        <p>Especialista en desarrollo backend y bases de datos. Gestor de la infraestructura del proyecto.</p>
                        <div class="social-links">
                            <a href="#" target="_blank"><i class="fab fa-github"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="creator-card animate-on-scroll">
                        <img src="{{ asset('images/sharith.jpg') }}" alt="Sharith Murillo" class="creator-image">
                        <h3>Sharith Murillo</h3>
                        <p class="text-muted">UX/UI Designer</p>
                        <p>Diseñadora de experiencia de usuario. Encargada de la investigación y diseño de interacción.</p>
                        <div class="social-links">
                            <a href="#" target="_blank"><i class="fab fa-github"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="creator-card animate-on-scroll">
                        <img src="{{ asset('images/santiago.jpg') }}" alt="Santiago Lozano" class="creator-image">
                        <h3>Santiago Lozano</h3>
                        <p class="text-muted">QA Engineer</p>
                        <p>Especialista en control de calidad y testing. Responsable de la optimización y rendimiento.</p>
                        <div class="social-links">
                            <a href="#" target="_blank"><i class="fab fa-github"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-light py-4">
        <div class="container text-center">
            <p class="mb-0">© 2024 My Job. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Existing scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').classList.add('scrolled');
            } else {
                document.querySelector('.navbar').classList.remove('scrolled');
            }
        });

        // Loading screen handler
        document.addEventListener('DOMContentLoaded', function() {
            const mainContent = document.querySelector('body');
            const loadingScreen = document.querySelector('.loading-screen');
            
            mainContent.style.visibility = 'hidden';
            
            setTimeout(function() {
                loadingScreen.classList.add('hidden');
                mainContent.style.visibility = 'visible';
                mainContent.style.opacity = '1';
                mainContent.style.transition = 'opacity 0.8s ease-in-out';
            }, 3000);
        });
    </script>
</body>
</html>
