@php
use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Empleador')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo2.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/empleador.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        if (window.axios) {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name=csrf-token]').content;
        }
    </script>
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
                    <a class="nav-link {{ request()->routeIs('empleador.agenda') ? 'active' : '' }}" href="{{ route('empleador.agenda') }}">
                        <i class="fas fa-fw fa-calendar-alt"></i>
                        <span>Agenda de Entrevistas</span>
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
                    <!-- User Profile Dropdown -->
                    <div class="dropdown ms-3">
                        <a href="#" class="dropdown-toggle text-decoration-none d-flex align-items-center" data-bs-toggle="dropdown">
                            @auth
                                @php
                                    $user = Auth::user();
                                    $foto = $user->foto_perfil;
                                    if ($foto) {
                                        if (filter_var($foto, FILTER_VALIDATE_URL)) {
                                            $imageSrc = $foto;
                                        } else {
                                            $imageSrc = Storage::url('public/' . $foto);
                                        }
                                    } else {
                                        $imageSrc = asset('images/user-default.svg');
                                    }
                                @endphp

                                @if($imageSrc)
                                    <img src="{{ $imageSrc }}" alt="Foto de perfil" class="rounded-circle m-2" style="width: 30px; height: 30px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary rounded-circle m-2 d-flex justify-content-center align-items-center" style="width: 30px; height: 30px;">
                                        <i class="fas fa-user text-white" style="font-size: 16px;"></i>
                                    </div>
                                @endif
                                <span>
                                    {{ $user->nombre_usuario }}
                                    @if(isset($user->verificado) && $user->verificado)
                                        <span title="Usuario verificado" style="color:#3b82f6; font-size:1.1em; vertical-align:middle; margin-left:0.2em;"><i class="fa-solid fa-circle-check"></i></span>
                                    @endif
                                </span>
                            @endauth
                            @guest
                                <span>Invitado</span>
                            @endguest
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('empleador.perfil') }}"><i class="fas fa-building me-2 text-muted"></i>Perfil de Empresa</a></li>
                            <li><a class="dropdown-item" href="{{ route('empleador.configuracion') }}"><i class="fas fa-cog me-2 text-muted"></i>Configuración</a></li>
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