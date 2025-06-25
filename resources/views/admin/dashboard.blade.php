@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Tarjetas de Estadísticas -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link btn-sm p-0 text-muted" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">Ver Usuarios</a></li>
                        </ul>
                    </div>
                </div>
                <h3 class="mb-2">{{ number_format($stats['total_users']) }}</h3>
                <p class="text-muted mb-0">Usuarios Totales</p>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="icon bg-success bg-opacity-10 text-success">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link btn-sm p-0 text-muted" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('admin.jobs.index') }}">Ver Ofertas</a></li>
                        </ul>
                    </div>
                </div>
                <h3 class="mb-2">{{ number_format($stats['active_jobs']) }}</h3>
                <p class="text-muted mb-0">Ofertas Activas</p>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="icon bg-info bg-opacity-10 text-info">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link btn-sm p-0 text-muted" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('admin.companies.index') }}">Ver Empresas</a></li>
                        </ul>
                    </div>
                </div>
                <h3 class="mb-2">{{ number_format($stats['total_employers']) }}</h3>
                <p class="text-muted mb-0">Empresas Registradas</p>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="icon bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link btn-sm p-0 text-muted" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('admin.reports') }}">Ver Reportes</a></li>
                        </ul>
                    </div>
                </div>
                <h3 class="mb-2">{{ number_format($stats['total_applications']) }}</h3>
                <p class="text-muted mb-0">Aplicaciones Totales</p>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Actividad Mensual</h5>
                </div>
                <div class="card-body">
                    <canvas id="activityChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Distribución de Usuarios</h5>
                </div>
                <div class="card-body">
                    <canvas id="usersChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tablas de Datos Recientes -->
    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Últimos Usuarios</h5>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">
                            Ver Todos
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Usuario</th>
                                <th>Rol</th>
                                <th>Fecha</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentUsers as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $user->foto_perfil ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->nombre_usuario) }}" 
                                             class="rounded-circle me-2" 
                                             width="32" 
                                             height="32"
                                             alt="{{ $user->nombre_usuario }}">
                                        {{ $user->nombre_usuario }}
                                    </div>
                                </td>
                                <td><span class="badge bg-{{ $user->rol === 'empleador' ? 'primary' : 'success' }}">{{ ucfirst($user->rol) }}</span></td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-light">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Últimas Ofertas</h5>
                        <a href="{{ route('admin.jobs.index') }}" class="btn btn-sm btn-primary">
                            Ver Todas
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Título</th>
                                <th>Empresa</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentJobs as $job)
                            <tr>
                                <td>{{ $job->titulo }}</td>
                                <td>{{ $job->empleador->usuario->nombre_usuario }}</td>
                                <td><span class="badge bg-{{ $job->estado === 'activa' ? 'success' : 'secondary' }}">{{ ucfirst($job->estado) }}</span></td>
                                <td>
                                    <a href="{{ route('admin.jobs.show', $job) }}" class="btn btn-sm btn-light">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Gráfico de Actividad Mensual
const activityCtx = document.getElementById('activityChart').getContext('2d');
new Chart(activityCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($usersLastMonth->pluck('date')) !!},
        datasets: [{
            label: 'Usuarios Nuevos',
            data: {!! json_encode($usersLastMonth->pluck('count')) !!},
            borderColor: '#4CAF50',
            backgroundColor: '#4CAF5020',
            fill: true,
            tension: 0.4
        }, {
            label: 'Ofertas Nuevas',
            data: {!! json_encode($jobsLastMonth->pluck('count')) !!},
            borderColor: '#2196F3',
            backgroundColor: '#2196F320',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Gráfico de Distribución de Usuarios
const usersCtx = document.getElementById('usersChart').getContext('2d');
new Chart(usersCtx, {
    type: 'doughnut',
    data: {
        labels: ['Empleadores', 'Empleados'],
        datasets: [{
            data: [
                {{ $stats['total_employers'] }},
                {{ $stats['total_employees'] }}
            ],
            backgroundColor: ['#4CAF50', '#2196F3'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        },
        cutout: '65%'
    }
});
</script>
@endpush
