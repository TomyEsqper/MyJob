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
                <li class="nav-item"><a href="{{ route('empleado.buscar') }}" class="nav-link {{ request()->routeIs('empleado.buscar') ? 'active' : '' }}"><i class="fas fa-search"></i> Buscar Empleos</a></li>
                <li class="nav-item"><a href="{{ route('empleado.notificaciones') }}" class="nav-link {{ request()->routeIs('empleado.notificaciones') ? 'active' : '' }}"><i class="fas fa-bell"></i> Notificaciones</a></li>
                <li class="nav-item"><a href="{{ route('empleado.perfil') }}" class="nav-link {{ request()->routeIs('empleado.perfil') ? 'active' : '' }}"><i class="fas fa-user"></i> Mi Perfil</a></li>
                <li class="nav-item"><a href="{{ route('empleado.configuracion') }}" class="nav-link {{ request()->routeIs('empleado.configuracion') ? 'active' : '' }}"><i class="fas fa-cog"></i> Configuración</a></li>
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
                @if (!request()->routeIs('empleado.dashboard'))
                <div class="header-userbar">
                    <a href="#" id="notificacionesDropdownBtn" class="notificaciones-btn text-decoration-none position-relative me-2">
                        <i class="fas fa-bell"></i>
                        <span id="notificacionesBadge" class="badge rounded-pill position-absolute top-0 start-100 translate-middle" style="display:none;"></span>
                    </a>
                    <div id="notificacionesDropdown" class="dropdown-menu dropdown-menu-end shadow" style="min-width: 320px; max-width: 400px; display: none; position: absolute; right: 0; top: 40px; z-index: 9999;">
                        <div class="dropdown-header">Notificaciones</div>
                        <div id="notificacionesList" style="max-height: 300px; overflow-y: auto;"></div>
                    </div>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle text-decoration-none d-flex align-items-center" data-bs-toggle="dropdown">
                            @auth
                                @php
                                    $foto = Auth::user()->foto_perfil;
                                    $fotoUrl = $foto ? (Str::startsWith($foto, 'http') ? $foto : asset('storage/' . $foto)) : asset('images/default-user.png');
                                @endphp
                                <img src="{{ $fotoUrl }}" class="rounded-circle" alt="Avatar">
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
                @endif
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
    @push('scripts')
    <script>
    function renderNotificaciones(notificaciones) {
        const list = document.getElementById('notificacionesList');
        const badge = document.getElementById('notificacionesBadge');
        if (!notificaciones.length) {
            list.innerHTML = `<div class='text-center py-4 text-muted'><i class='fas fa-bell fa-2x mb-2'></i><div>No tienes notificaciones nuevas.</div></div>`;
            badge.style.display = 'none';
            return;
        }
        let noLeidas = notificaciones.filter(n => !n.leida).length;
        badge.textContent = noLeidas;
        badge.style.display = noLeidas > 0 ? '' : 'none';
        list.innerHTML = '';
        notificaciones.slice(0, 10).forEach(n => {
            let icon = n.tipo === 'success' ? 'fa-check-circle text-success' : (n.tipo === 'warning' ? 'fa-exclamation-triangle text-warning' : 'fa-info-circle text-info');
            list.innerHTML += `<div class='dropdown-item border-bottom border-light d-flex align-items-start gap-2 py-2'>
                <i class='fas ${icon} mt-1'></i>
                <div style='flex:1;'>
                    <div style='font-size:1.01rem;'>${n.mensaje}</div>
                    <div class='text-muted small mt-1'>${n.fecha}</div>
                </div>
            </div>`;
        });
    }

    function cargarNotificacionesDropdown() {
        fetch("{{ route('empleado.notificaciones.ajax') }}")
            .then(res => res.json())
            .then(data => renderNotificaciones(data));
    }

    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('notificacionesDropdownBtn');
        const dropdown = document.getElementById('notificacionesDropdown');
        const badge = document.getElementById('notificacionesBadge');
        // Cargar badge al inicio
        fetch("{{ route('empleado.notificaciones.ajax') }}")
            .then(res => res.json())
            .then(data => {
                let noLeidas = data.filter(n => !n.leida).length;
                badge.textContent = noLeidas;
                badge.style.display = noLeidas > 0 ? '' : 'none';
            });
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            if (dropdown.style.display === 'block') {
                cargarNotificacionesDropdown();
            }
        });
        // Cerrar el dropdown al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    });
    </script>
    @endpush
</body>
</html> 