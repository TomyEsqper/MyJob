<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Empleador')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/empleador.css') }}">
    @stack('styles')
</head>
<body>
    <div class="dashboard-container">
        <button class="hamburger-btn d-lg-none" id="hamburgerMenu" aria-label="Abrir menú">
            <span></span><span></span><span></span>
        </button>
        <aside class="sidebar-empleador" id="sidebarEmpleador">
            <div class="logo-box d-flex align-items-center p-3 mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" height="50">
            </div>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="{{ route('empleador.dashboard') }}" class="nav-link {{ request()->routeIs('empleador.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('empleador.ofertas.index') }}" class="nav-link {{ request()->routeIs('empleador.ofertas.*') ? 'active' : '' }}"><i class="fas fa-briefcase"></i> Mis Ofertas</a></li>
                <li class="nav-item"><a href="{{ route('empleador.candidatos') }}" class="nav-link {{ request()->routeIs('empleador.candidatos.*') ? 'active' : '' }}"><i class="fas fa-users"></i> Candidatos</a></li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="fas fa-chart-line"></i> Estadísticas</a></li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="fas fa-bell"></i> Notificaciones</a></li>
                <li class="nav-item"><a href="{{ route('empleador.perfil') }}" class="nav-link {{ request()->routeIs('empleador.perfil') ? 'active' : '' }}"><i class="fas fa-building"></i> Mi Empresa</a></li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="fas fa-cog"></i> Configuración</a></li>
                <li class="nav-item mt-5">
                    <form action="{{ route('logout') }}" method="POST" class="nav-link">
                        @csrf
                        <button type="submit" class="btn btn-link text-danger p-0"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</button>
                    </form>
                </li>
            </ul>
        </aside>
        <main class="main-empleador">
            <header class="header-empleador mb-4">
                <div class="welcome-banner">
                    <h2 class="mb-1">@yield('page-title', 'Dashboard')</h2>
                    <p class="mb-0">@yield('page-description', 'Bienvenido a tu panel de empleador')</p>
                </div>
                <div class="user-profile-empleador">
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle text-decoration-none" data-bs-toggle="dropdown">
                            <i class="fas fa-bell text-muted"></i>
                            <span class="badge rounded-pill bg-danger">5</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">Notificaciones recientes</h6></li>
                            <li><a class="dropdown-item" href="#">Nuevo candidato para Desarrollador Frontend</a></li>
                            <li><a class="dropdown-item" href="#">Nuevo candidato para Diseñador UX/UI</a></li>
                            <li><a class="dropdown-item" href="#">Oferta a punto de expirar</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-primary" href="#">Ver todas</a></li>
                        </ul>
                    </div>
                    <div class="dropdown ms-3">
                        <a href="#" class="dropdown-toggle text-decoration-none d-flex align-items-center" data-bs-toggle="dropdown">
                            @auth
                                @php
                                    $user = Auth::user();
                                    $empleador = $user->empleador;
                                    $imageSrc = null;

                                    // Prioridad 1: Logo de la empresa
                                    if ($empleador && $empleador->logo_empresa) {
                                        $imageSrc = asset('storage/' . $empleador->logo_empresa);
                                    }
                                    // Prioridad 2: Foto de perfil de Google
                                    elseif ($user->foto_perfil) {
                                        // Verificar si es una URL completa o una ruta guardada
                                        if (filter_var($user->foto_perfil, FILTER_VALIDATE_URL)) {
                                            $imageSrc = $user->foto_perfil;
                                        } else {
                                            $imageSrc = asset('storage/' . $user->foto_perfil);
                                        }
                                    }
                                @endphp

                                @if($imageSrc)
                                    <img src="{{ $imageSrc }}" alt="Logo" class="rounded-circle m-2" style="width: 30px; height: 30px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary rounded-circle m-2 d-flex justify-content-center align-items-center" style="width: 30px; height: 30px;">
                                        <i class="fas fa-building text-white" style="font-size: 16px;"></i>
                                    </div>
                                @endif
                                <span>{{ $user->nombre_empresa ?? $user->nombre_usuario }}</span>
                            @endauth
                            @guest
                                <span>Invitado</span>
                            @endguest
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('empleador.perfil') }}"><i class="fas fa-building me-2 text-muted"></i>Perfil de Empresa</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2 text-muted"></i>Configuración</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</button>
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
            document.getElementById('sidebarEmpleador').classList.toggle('sidebar-open');
        });
    </script>
    @stack('scripts')
</body>
</html> 