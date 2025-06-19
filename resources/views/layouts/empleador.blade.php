<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyJob - Panel Empleador</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #28a745;
            --secondary-color: #6c757d;
            --sidebar-width: 250px;
        }

        .sidebar {
            width: var(--sidebar-width);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background-color: #ffffff;
            border-right: 1px solid rgba(0, 0, 0, 0.1);
            padding: 1rem;
            z-index: 1000;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
        }

        .logo-container {
            padding: 1rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .logo-container img {
            width: 50px;
            height: 50px;
        }

        .logo-container .brand {
            font-size: 1.5rem;
            margin-top: 0.5rem;
            color: #333;
            text-decoration: none;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.8rem 1rem;
            color: var(--secondary-color);
            text-decoration: none;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--primary-color);
        }

        .nav-link.active {
            background-color: var(--primary-color);
            color: white;
        }

        .nav-link i {
            width: 24px;
            margin-right: 0.8rem;
            font-size: 1.2rem;
        }

        .nav-link span {
            font-size: 1rem;
        }

        .logout-link {
            position: absolute;
            bottom: 1rem;
            left: 1rem;
            right: 1rem;
            color: #dc3545;
        }

        .logout-link:hover {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .toggle-sidebar {
                display: block !important;
            }
        }

        .toggle-sidebar {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1001;
            background-color: var(--primary-color);
            border: none;
            padding: 0.5rem;
            border-radius: 0.25rem;
            color: white;
        }
    </style>
    @stack('styles')
</head>
<body>
    <button class="toggle-sidebar btn">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo-container">
            <img src="{{ asset('images/logo.png') }}" alt="MyJob Logo">
            <div class="brand">MyJob</div>
        </div>

        <nav>
            <a href="{{ route('empleador.dashboard') }}" class="nav-link {{ request()->routeIs('empleador.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt text-primary"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('empleador.ofertas.index') }}" class="nav-link {{ request()->routeIs('empleador.ofertas.*') ? 'active' : '' }}">
                <i class="fas fa-briefcase text-success"></i>
                <span>Mis Ofertas</span>
            </a>

            <a href="{{ route('empleador.candidatos') }}" class="nav-link {{ request()->routeIs('empleador.candidatos') ? 'active' : '' }}">
                <i class="fas fa-users text-primary"></i>
                <span>Candidatos</span>
            </a>

            <a href="{{ route('empleador.empresa') }}" class="nav-link {{ request()->routeIs('empleador.empresa') ? 'active' : '' }}">
                <i class="fas fa-building text-warning"></i>
                <span>Mi Empresa</span>
            </a>

            <a href="{{ route('empleador.estadisticas') }}" class="nav-link {{ request()->routeIs('empleador.estadisticas') ? 'active' : '' }}">
                <i class="fas fa-chart-line text-success"></i>
                <span>Estadísticas</span>
            </a>

            <a href="{{ route('empleador.notificaciones') }}" class="nav-link {{ request()->routeIs('empleador.notificaciones') ? 'active' : '' }}">
                <i class="fas fa-bell text-warning"></i>
                <span>Notificaciones</span>
            </a>

            <a href="{{ route('empleador.configuracion') }}" class="nav-link {{ request()->routeIs('empleador.configuracion') ? 'active' : '' }}">
                <i class="fas fa-cog text-secondary"></i>
                <span>Configuración</span>
            </a>

            <form action="{{ route('logout') }}" method="POST" class="logout-link">
                @csrf
                <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Cerrar Sesión</span>
                </button>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('.toggle-sidebar').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });

        // Cerrar sidebar en móvil al hacer clic en un enlace
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    document.querySelector('.sidebar').classList.remove('show');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html> 