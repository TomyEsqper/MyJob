<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel de Administración') - MyJob</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', Arial, sans-serif;
            background: #f4f6fb;
            color: #222;
        }
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #1e293b 80%, #10b981 100%);
            color: #fff;
            display: flex;
            flex-direction: column;
            padding: 2rem 1rem 1rem 1.5rem;
            box-shadow: 2px 0 12px #0001;
        }
        .sidebar h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 2rem;
            margin-bottom: 2.5rem;
            letter-spacing: 1px;
        }
        .sidebar nav {
            flex: 1;
        }
        .sidebar nav a {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: #fff;
            text-decoration: none;
            font-size: 1.1rem;
            padding: 0.8rem 0.5rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            transition: background 0.2s;
        }
        .sidebar nav a.active, .sidebar nav a:hover {
            background: #10b981;
        }
        .sidebar .logout {
            margin-top: 2rem;
            color: #f87171;
            font-weight: bold;
            cursor: pointer;
            border: none;
            background: none;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }
        .main-content {
            flex: 1;
            padding: 2.5rem 3rem;
            display: flex;
            flex-direction: column;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2.5rem;
        }
        .header .welcome {
            font-family: 'Montserrat', sans-serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: #1e293b;
        }
        .header .admin-info {
            display: flex;
            align-items: center;
            gap: 1.2rem;
        }
        .header .admin-info .avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #10b981;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.7rem;
            font-weight: bold;
        }
        .header .admin-info .name {
            font-size: 1.1rem;
            font-weight: 500;
            color: #222;
        }
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 2rem;
            margin-bottom: 2.5rem;
        }
        .card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px #0001;
            padding: 2rem 1.5rem 1.5rem 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            position: relative;
            overflow: hidden;
        }
        .card .icon {
            font-size: 2.2rem;
            margin-bottom: 1rem;
            color: #10b981;
        }
        .card .label {
            font-size: 1.1rem;
            color: #64748b;
            margin-bottom: 0.3rem;
        }
        .card .value {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
        }
        .quick-actions {
            margin-top: 1.5rem;
        }
        .quick-actions h3 {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            color: #10b981;
        }
        .quick-actions .actions {
            display: flex;
            gap: 1.5rem;
        }
        .quick-actions .actions a {
            background: #10b981;
            color: #fff;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            box-shadow: 0 2px 8px #10b98133;
            transition: background 0.2s;
        }
        .quick-actions .actions a:hover {
            background: #059669;
        }
        .filters-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px #0001;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .filters-card h3 {
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            color: #10b981;
            font-weight: 600;
        }
        .table-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px #0001;
            padding: 2rem;
        }
        .table-card h3 {
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            color: #10b981;
            font-weight: 600;
        }
        .table {
            margin-bottom: 0;
        }
        .table th {
            border-top: none;
            font-weight: 600;
            color: #64748b;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table td {
            vertical-align: middle;
            border-color: #f1f5f9;
        }
        .btn-action {
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
            border-radius: 6px;
            margin-right: 0.3rem;
        }
        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .status-activa {
            background: #dcfce7;
            color: #166534;
        }
        .status-inactiva {
            background: #fef2f2;
            color: #dc2626;
        }
        .company-logo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .pagination {
            margin-top: 2rem;
        }
        .pagination .page-link {
            color: #10b981;
            border-color: #e2e8f0;
        }
        .pagination .page-item.active .page-link {
            background: #10b981;
            border-color: #10b981;
        }
        @media (max-width: 900px) {
            .main-content { padding: 1.5rem 0.5rem; }
            .dashboard-cards { gap: 1rem; }
        }
        @media (max-width: 600px) {
            .admin-layout { flex-direction: column; }
            .sidebar { width: 100%; flex-direction: row; padding: 1rem; }
            .sidebar h2 { font-size: 1.3rem; margin-bottom: 1rem; }
            .sidebar nav { flex-direction: row; gap: 0.5rem; }
            .main-content { padding: 1rem 0.2rem; }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="admin-layout">
    <aside class="sidebar">
        <h2><i class="fa-solid fa-user-shield"></i> Admin</h2>
        <nav>
            <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge"></i> Dashboard
            </a>
            <a href="/admin/usuarios" class="{{ request()->is('admin/usuarios') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> Usuarios
            </a>
            <a href="/admin/ofertas" class="{{ request()->is('admin/ofertas*') ? 'active' : '' }}">
                <i class="fa-solid fa-briefcase"></i> Ofertas
            </a>
            <a href="/admin/empresas" class="{{ request()->is('admin/empresas*') ? 'active' : '' }}">
                <i class="fa-solid fa-building"></i> Empresas
            </a>
            <a href="/admin/reportes" class="{{ request()->is('admin/reportes*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-lines"></i> Reportes
            </a>
            <a href="/admin/configuracion" class="{{ request()->is('admin/configuracion*') ? 'active' : '' }}">
                <i class="fa-solid fa-gear"></i> Configuración
            </a>
        </nav>
        <form method="POST" action="/logout">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="logout">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar sesión
            </button>
        </form>
    </aside>
    <main class="main-content">
        <div class="header">
            <div class="welcome">@yield('page-title', 'Panel de Administración')</div>
            <div class="admin-info">
                <div class="avatar"><i class="fa-solid fa-user-tie"></i></div>
                <div class="name">{{ auth()->user()->nombre_usuario ?? 'Admin' }}</div>
            </div>
        </div>
        
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('scripts')
</body>
</html> 