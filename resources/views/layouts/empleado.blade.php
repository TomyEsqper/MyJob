<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Empleado')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/empleado.css') }}">
    @stack('styles')
</head>
<body>
    <div class="dashboard-container">
        <button class="hamburger-btn d-lg-none" id="hamburgerMenu" aria-label="Abrir menú">
            <span></span><span></span><span></span>
        </button>
        <aside class="sidebar-empleado" id="sidebarEmpleado">
            <div class="logo-box d-flex align-items-center p-3 mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" height="50">
            </div>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="{{ route('empleado.dashboard') }}" class="nav-link {{ request()->routeIs('empleado.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('empleado.aplicaciones') }}" class="nav-link {{ request()->routeIs('empleado.aplicaciones') ? 'active' : '' }}"><i class="fas fa-briefcase"></i> Mis Aplicaciones</a></li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="fas fa-search"></i> Buscar Empleos</a></li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="fas fa-file-alt"></i> Mi CV</a></li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="fas fa-bell"></i> Notificaciones</a></li>
                <li class="nav-item"><a href="{{ route('empleado.perfil') }}" class="nav-link {{ request()->routeIs('empleado.perfil') ? 'active' : '' }}"><i class="fas fa-user"></i> Mi Perfil</a></li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="fas fa-cog"></i> Configuración</a></li>
                <li class="nav-item mt-5">
                    <form action="{{ route('logout') }}" method="POST" class="nav-link">
                        @csrf
                        <button type="submit" class="btn btn-link text-danger p-0"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</button>
                    </form>
                </li>
            </ul>
        </aside>
        <main class="main-empleado">
            <header class="header-empleado mb-4">
                <div class="welcome-banner">
                    <h2 class="mb-1">@yield('page-title', 'Dashboard')</h2>
                    <p class="mb-0">@yield('page-description', 'Bienvenido a tu panel de empleado')</p>
                </div>
                <div class="user-profile-empleado">
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
                                <img src="{{ Auth::user()->foto_perfil ?? asset('images/default-user.png') }}" class="rounded-circle m-2" width="30">
                                <span>{{ Auth::user()->nombre_usuario }}</span>
                            @endauth
                            @guest
                                <span>Invitado</span>
                            @endguest
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('empleado.perfil') }}">Mi Perfil</a></li>
                            <li><a class="dropdown-item" href="#">Configuración</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Cerrar Sesión</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Hamburguesa para sidebar en móviles
        document.getElementById('hamburgerMenu').addEventListener('click', function() {
            document.getElementById('sidebarEmpleado').classList.toggle('sidebar-open');
        });
    </script>
    @stack('scripts')
</body>
</html> 