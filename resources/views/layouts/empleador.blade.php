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
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('empleador.dashboard') ? 'active' : '' }}" href="{{ route('empleador.dashboard') }}">
                        <i class="fas fa-fw fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('empleador.ofertas.*') ? 'active' : '' }}" href="{{ route('empleador.ofertas.index') }}">
                        <i class="fas fa-fw fa-briefcase"></i>
                        <span>Mis Ofertas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('empleador.candidatos*') ? 'active' : '' }}" href="{{ route('empleador.candidatos') }}">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Candidatos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('empleador.estadisticas') ? 'active' : '' }}" href="{{ route('empleador.estadisticas') }}">
                        <i class="fas fa-fw fa-chart-bar"></i>
                        <span>Estadísticas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('empleador.notificaciones') ? 'active' : '' }}" 
                       href="{{ route('empleador.notificaciones') }}">
                        <i class="fas fa-bell"></i>
                        <span>Notificaciones</span>
                        @if(Auth::user()->notificaciones()->where('leida', false)->count() > 0)
                            <span class="badge bg-danger rounded-pill ms-2">
                                {{ Auth::user()->notificaciones()->where('leida', false)->count() }}
                            </span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('empleador.perfil') || request()->routeIs('empleador.empresa') ? 'active' : '' }}" href="{{ route('empleador.perfil') }}">
                        <i class="fas fa-fw fa-building"></i>
                        <span>Mi Empresa</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('empleador.configuracion') ? 'active' : '' }}" href="{{ route('empleador.configuracion') }}">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Configuración</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-fw fa-sign-out-alt"></i>
                        <span>Cerrar Sesión</span>
                    </a>
                </li>
            </ul>
        </aside>
        
        <!-- Formulario oculto para cerrar sesión -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
        
        <main class="main-empleador">
            <header class="header-empleador mb-4">
                <div class="welcome-banner">
                    <h2 class="mb-1">@yield('page-title', 'Dashboard')</h2>
                    <p class="mb-0">@yield('page-description', 'Bienvenido a tu panel de empleador')</p>
                </div>
                <div class="d-flex align-items-center">
                    <!-- Notificaciones Dropdown -->
                    <div class="dropdown me-3">
                        <button class="btn btn-link text-dark position-relative p-0" 
                                type="button" 
                                id="dropdownNotificaciones" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false">
                            <i class="fas fa-bell fa-lg"></i>
                            <span id="contador-notificaciones" 
                                  class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                  style="{{ Auth::user()->notificaciones()->where('leida', false)->count() > 0 ? '' : 'display: none;' }}">
                                {{ Auth::user()->notificaciones()->where('leida', false)->count() }}
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end shadow-sm py-0" 
                             aria-labelledby="dropdownNotificaciones"
                             style="width: 320px; max-height: 480px; overflow-y: auto;">
                            <div class="p-3 border-bottom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Notificaciones</h6>
                                    <a href="{{ route('empleador.notificaciones') }}" class="text-primary text-decoration-none">Ver todas</a>
                                </div>
                            </div>
                            <div class="notificaciones-lista">
                                @forelse(Auth::user()->notificaciones()->where('leida', false)->take(5)->get() as $notificacion)
                                    <div class="dropdown-item-text p-3 border-bottom" id="notificacion-preview-{{ $notificacion->id }}">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="rounded-circle p-2 {{ $notificacion->color_clase }} bg-opacity-10">
                                                    <i class="{{ $notificacion->icono_clase }}"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1 fw-semibold">{{ $notificacion->titulo }}</h6>
                                                <p class="mb-1 small text-muted">{{ Str::limit($notificacion->mensaje, 100) }}</p>
                                                <small class="text-muted">{{ $notificacion->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4">
                                        <i class="fas fa-bell-slash text-muted mb-2"></i>
                                        <p class="text-muted mb-0 small">No hay notificaciones nuevas</p>
                                    </div>
                                @endforelse
                            </div>
                            @if(Auth::user()->notificaciones()->where('leida', false)->count() > 0)
                                <div class="p-3 border-top">
                                    <button onclick="marcarTodasComoLeidas()" class="btn btn-light btn-sm w-100">
                                        <i class="fas fa-check-double me-1"></i>
                                        Marcar todas como leídas
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- User Profile Dropdown -->
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