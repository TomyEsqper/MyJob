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
    <link rel="icon" type="image/png" href="{{ asset('images/logo2.png') }}">
</head>
<body style="opacity:1; transition: opacity 0.8s;">
<!-- Actualizar la pantalla de carga -->
<div class="loading-screen">
    <div class="loader-container">
        <div class="loader-spinner"></div>
        <img src="{{ asset('images/logo.png') }}" alt="Cargando My Job..." class="loading-logo" />
    </div>
    <div class="mt-3 text-center">
        <p class="text-muted">Cargando My Job...</p>
    </div>
</div>
<!-- Actualiza la sección del navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('images/logo2.png') }}" alt="My Job logo" class="nav-logo" width="40" height="40">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="#inicio">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#funciones">Funciones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#nosotros">Sobre Nosotros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#creadores">Creadores</a>
                </li>
                <!-- Actualizar solo los botones en el navbar -->
                <li class="nav-item">
                    <a class="btn btn-light me-lg-2 mb-2 mb-lg-0" href="{{ route('login') }}">Iniciar Sesión</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-success" href="{{ route('register') }}">Registrarse</a>
                </li>
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
                        <img src="{{ asset('images/cuervo.jpeg') }}" alt="Camilo Cuervo" class="creator-image">
                        <h3>Camilo Cuervo</h3>
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
                        <img src="{{ asset('images/tomas.jpg') }}" alt="Tomás Esquivel" class="creator-image">
                        <h3>Tomás Esquivel</h3>
                        <p class="text-muted">Desarrollador Full Stack </p>
                        <p>Especialista en desarrollo web y arquitectura de software. Líder técnico del proyecto.</p>
                        <div class="social-links">
                            <a href="#" target="_blank"><i class="fab fa-github"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="creator-card animate-on-scroll">
                        <img src="{{ asset('images/nicolas.jpeg') }}" alt="Nicolás Plazas" class="creator-image">
                        <h3>Nicolás Plazas</h3>
                        <p class="text-muted">Desarrollador Full Stack </p>
                        <p>Desarrollador full stack encargado del frontend y backend del sistema.</p>
                        <div class="social-links">
                            <a href="#" target="_blank"><i class="fab fa-github"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="creator-card animate-on-scroll">
                        <img src="{{ asset('images/sharith.jpeg') }}" alt="Sharith Murillo" class="creator-image">
                        <h3>Sharith Murillo</h3>
                        <p class="text-muted"></p>
                        <p class="text-muted">Diseñadora gráfica y documentación</p>
                        <p>Responsable de la identidad visual del proyecto y de la creación de manuales técnicos y de usuario.</p>
                        <div class="social-links">
                            <a href="#" target="_blank"><i class="fab fa-github"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="creator-card animate-on-scroll">
                        <img src="#" alt="Santiago Lozano" class="creator-image">
                        <h3>Santiago Lozano</h3>
                        <p class="text-muted">UX/UI Designer</p>
                        <p>Diseñador de experiencia de usuario. Encargado de la investigación y diseño de interacción.</p>
                        <div class="social-links">
                            <a href="#" target="_blank"><i class="fab fa-github"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


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
        const loadingScreen = document.querySelector('.loading-screen');
        const body = document.body;

        window.addEventListener('load', function() {
            setTimeout(function() {
                loadingScreen.classList.add('hidden');
                body.style.opacity = '1';
            }, 1000);
        });
    });

    // Animate on scroll
    function animateOnScroll() {
        document.querySelectorAll('.animate-on-scroll').forEach(function(el) {
            const rect = el.getBoundingClientRect();
            if (rect.top < window.innerHeight - 100) {
                el.classList.add('visible');
            }
        });
    }
    window.addEventListener('scroll', animateOnScroll);
    window.addEventListener('DOMContentLoaded', animateOnScroll);
</script>
<!-- Agregar antes del cierre del body -->
<footer class="footer bg-dark text-light pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row gy-4">
            <!-- Información de la empresa -->
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="footer-section">
                    <div class="footer-logo mb-3 d-flex align-items-center">
                        <img src="{{ asset('images/logo2.png') }}" alt="My Job" width="50" height="50" class="me-2">
                        <span class="footer-brand fw-bold fs-4">My Job</span>
                    </div>
                    <p class="footer-description small">
                        Conectando talento con oportunidades. La plataforma que impulsa tu carrera profesional.
                    </p>
                    <div class="footer-social mt-3">
                        <a href="#" class="social-link me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link me-2"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <!-- Enlaces rápidos -->
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                <div class="footer-section">
                    <h5 class="footer-title mb-3">Enlaces</h5>
                    <ul class="footer-links list-unstyled">
                        <li><a href="#inicio" class="footer-link">Inicio</a></li>
                        <li><a href="#funciones" class="footer-link">Funciones</a></li>
                        <li><a href="#nosotros" class="footer-link">Nosotros</a></li>
                        <li><a href="#creadores" class="footer-link">Creadores</a></li>
                        <li><a href="{{ route('login') }}" class="footer-link">Iniciar Sesión</a></li>
                    </ul>
                </div>
            </div>
            <!-- Contacto -->
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="footer-section">
                    <h5 class="footer-title mb-3">Contacto</h5>
                    <ul class="footer-contact list-unstyled small">
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@myjob.com</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> +57 300 123 4567</li>
                        <li><i class="fas fa-map-marker-alt me-2"></i> Colombia</li>
                    </ul>
                </div>
            </div>
            <!-- Formulario PQRS -->
            <div class="col-lg-4 col-md-6">
                <div class="footer-section">
                    <h5 class="footer-title mb-3">PQRS</h5>
                    <p class="footer-subtitle small mb-2">¿Tienes alguna pregunta, queja, reclamo o sugerencia?</p>
                    <form class="pqrs-form" id="pqrsForm" method="POST" action="{{ route('pqrs.send') }}">
                        @csrf
                        <div class="form-group mb-2">
                            <input type="text" class="form-control form-control-sm" name="nombre" placeholder="Tu nombre" required>
                        </div>
                        <div class="form-group mb-2">
                            <input type="email" class="form-control form-control-sm" name="email" placeholder="Tu email" required>
                        </div>
                        <div class="form-group mb-2">
                            <select class="form-control form-control-sm" name="tipo" required>
                                <option value="">Tipo de solicitud</option>
                                <option value="Pregunta">Pregunta</option>
                                <option value="Queja">Queja</option>
                                <option value="Reclamo">Reclamo</option>
                                <option value="Sugerencia">Sugerencia</option>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <textarea class="form-control form-control-sm" name="mensaje" rows="2" placeholder="Tu mensaje" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm w-100" id="pqrsBtn">Enviar PQRS</button>
                        <div id="pqrsMsg" class="mt-2 small"></div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Footer bottom -->
        <div class="footer-bottom border-top border-secondary mt-4 pt-3">
            <div class="row align-items-center">
                <div class="col-md-6 small">
                    © 2024 My Job. Todos los derechos reservados.
                </div>
                <div class="col-md-6 text-md-end small">
                    <a href="#" class="footer-link me-3">Términos de Uso</a>
                    <a href="#" class="footer-link">Política de Privacidad</a>
                </div>
            </div>
        </div>
    </div>
</footer>
<script>
// PQRS AJAX
const pqrsForm = document.getElementById('pqrsForm');
if (pqrsForm) {
    pqrsForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(pqrsForm);
        const msg = document.getElementById('pqrsMsg');
        const btn = document.getElementById('pqrsBtn');
        msg.textContent = '';
        btn.disabled = true;
        btn.classList.add('disabled');
        btn.textContent = 'Enviando...';
        fetch(pqrsForm.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': formData.get('_token'),
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                msg.textContent = '¡Tu PQRS fue enviado exitosamente!';
                msg.className = 'text-success';
                pqrsForm.reset();
            } else {
                msg.textContent = data.message || 'Hubo un error al enviar tu PQRS.';
                msg.className = 'text-danger';
                btn.disabled = false;
                btn.classList.remove('disabled');
                btn.textContent = 'Enviar PQRS';
            }
        })
        .catch(() => {
            msg.textContent = 'Hubo un error al enviar tu PQRS.';
            msg.className = 'text-danger';
            btn.disabled = false;
            btn.classList.remove('disabled');
            btn.textContent = 'Enviar PQRS';
        });
    });
}
</script>
</body>
</html>
