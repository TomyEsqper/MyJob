@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page-title', '¡Bienvenido, Administrador!')

@section('content')
<section class="dashboard-cards">
    <div class="card">
        <div class="icon"><i class="fa-solid fa-users"></i></div>
        <div class="label">Usuarios registrados</div>
        <div class="value">{{ $usuariosCount }}</div>
    </div>
    <div class="card">
        <div class="icon"><i class="fa-solid fa-briefcase"></i></div>
        <div class="label">Ofertas activas</div>
        <div class="value">{{ $ofertasCount }}</div>
    </div>
    <div class="card">
        <div class="icon"><i class="fa-solid fa-building"></i></div>
        <div class="label">Empresas</div>
        <div class="value">{{ $empresasCount }}</div>
    </div>
    <div class="card">
        <div class="icon"><i class="fa-solid fa-file-lines"></i></div>
        <div class="label">Reportes</div>
        <div class="value">--</div>
    </div>
</section>

<section class="quick-actions">
    <h3>Acciones rápidas</h3>
    <div class="actions">
        <a href="/admin/usuarios"><i class="fa-solid fa-users"></i> Gestionar Usuarios</a>
        <a href="/admin/ofertas"><i class="fa-solid fa-briefcase"></i> Gestionar Ofertas</a>
        <a href="/admin/empresas"><i class="fa-solid fa-building"></i> Gestionar Empresas</a>
    </div>
</section>
@endsection 