@extends('layouts.admin')

@section('title', 'Reportes')
@section('page-title', 'Reportes y Estadísticas')

@section('content')
<div class="dashboard-cards mb-4">
    <div class="card clickable" onclick="window.location.href='/admin/usuarios'">
        <div class="icon"><i class="fa-solid fa-users"></i></div>
        <div class="label">Usuarios</div>
        <div class="value">{{ $usuariosCount }}</div>
        <div class="small text-muted">
            <a href="/admin/usuarios?activo=1" class="text-success">Activos: {{ $usuariosActivos }}</a> | 
            <a href="/admin/usuarios?activo=0" class="text-warning">Inactivos: {{ $usuariosInactivos }}</a>
        </div>
    </div>
    <div class="card clickable" onclick="window.location.href='/admin/empresas'">
        <div class="icon"><i class="fa-solid fa-building"></i></div>
        <div class="label">Empresas</div>
        <div class="value">{{ $empresasCount }}</div>
        <div class="small text-muted">
            <a href="/admin/empresas?verificado=1" class="text-success">Verificadas: {{ $empresasVerificadas }}</a> | 
            <a href="/admin/empresas?verificado=0" class="text-danger">No verificadas: {{ $empresasNoVerificadas }}</a>
        </div>
    </div>
    <div class="card clickable" onclick="window.location.href='/admin/ofertas'">
        <div class="icon"><i class="fa-solid fa-briefcase"></i></div>
        <div class="label">Ofertas</div>
        <div class="value">{{ $ofertasCount }}</div>
        <div class="small text-muted">
            <a href="/admin/ofertas?estado=activa" class="text-success">Activas: {{ $ofertasActivas }}</a> | 
            <a href="/admin/ofertas?estado=inactiva" class="text-warning">Inactivas: {{ $ofertasInactivas }}</a>
        </div>
    </div>
    <div class="card clickable" onclick="window.location.href='/admin/aplicaciones'">
        <div class="icon"><i class="fa-solid fa-paper-plane"></i></div>
        <div class="label">Aplicaciones</div>
        <div class="value">{{ $aplicacionesCount }}</div>
        <div class="small text-muted">Total de solicitudes</div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6 mb-4">
        <div class="table-card">
            <h3 class="mb-3"><i class="fa-solid fa-chart-line me-2"></i>Evolución mensual</h3>
            <canvas id="evolucionChart" height="200"></canvas>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="table-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3><i class="fa-solid fa-ranking-star me-2"></i>Top Usuarios Destacados</h3>
                <a href="/admin/usuarios?destacado=1" class="btn btn-sm btn-outline-primary">Ver todos destacados</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover w-100 mb-0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Destacado</th>
                            <th>Verificado</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($topUsuarios as $u)
                        <tr class="clickable" onclick="window.location.href='/admin/usuarios/{{ $u->id_usuario }}/profile'">
                            <td>{{ $u->nombre_usuario }}</td>
                            <td>{{ $u->correo_electronico }}</td>
                            <td>@if($u->destacado)<i class="fa-solid fa-star text-warning"></i>@endif</td>
                            <td>@if($u->verificado)<i class="fa-solid fa-circle-check text-primary"></i>@endif</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row mb-4">
    <div class="col-md-6 mb-4">
        <div class="table-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3><i class="fa-solid fa-trophy me-2"></i>Top Empresas Verificadas</h3>
                <a href="/admin/empresas?verificado=1" class="btn btn-sm btn-outline-primary">Ver todas verificadas</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover w-100 mb-0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Verificada</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($topEmpresas as $e)
                        <tr class="clickable" onclick="window.location.href='/admin/empresas/{{ $e->id_usuario }}/profile'">
                            <td>{{ $e->nombre_usuario }}</td>
                            <td>{{ $e->correo_electronico }}</td>
                            <td>@if($e->verificado)<i class="fa-solid fa-circle-check text-primary"></i>@endif</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="table-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3><i class="fa-solid fa-briefcase me-2"></i>Top Ofertas con más Aplicaciones</h3>
                <a href="/admin/ofertas" class="btn btn-sm btn-outline-primary">Ver todas las ofertas</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover w-100 mb-0">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Empresa</th>
                            <th>Aplicaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($topOfertas as $o)
                        <tr class="clickable" onclick="window.location.href='/admin/ofertas/{{ $o->id_oferta }}'">
                            <td>{{ Str::limit($o->titulo, 30) }}</td>
                            <td>{{ $o->empleador->empleador->nombre_empresa ?? $o->empleador->nombre_usuario ?? '-' }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $o->aplicaciones_count }}</span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Sección de acciones rápidas -->
<div class="row mb-4">
    <div class="col-12">
        <div class="table-card">
            <h3 class="mb-3"><i class="fa-solid fa-bolt me-2"></i>Acciones Rápidas</h3>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <a href="/admin/usuarios?activo=0" class="btn btn-warning btn-lg w-100">
                        <i class="fa-solid fa-user-slash me-2"></i>
                        <div>Usuarios Inactivos</div>
                        <small>{{ $usuariosInactivos }} pendientes</small>
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="/admin/usuarios?verificado=0" class="btn btn-danger btn-lg w-100">
                        <i class="fa-solid fa-user-check me-2"></i>
                        <div>Sin Verificar</div>
                        <small>{{ $usuariosInactivos + $empresasNoVerificadas }} total</small>
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="/admin/empresas?verificado=0" class="btn btn-info btn-lg w-100">
                        <i class="fa-solid fa-building me-2"></i>
                        <div>Empresas Pendientes</div>
                        <small>{{ $empresasNoVerificadas }} sin verificar</small>
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="/admin/ofertas?estado=inactiva" class="btn btn-secondary btn-lg w-100">
                        <i class="fa-solid fa-briefcase me-2"></i>
                        <div>Ofertas Inactivas</div>
                        <small>{{ $ofertasInactivas }} por revisar</small>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sección de estadísticas detalladas -->
<div class="row mb-4">
    <div class="col-md-6 mb-4">
        <div class="table-card">
            <h3 class="mb-3"><i class="fa-solid fa-chart-pie me-2"></i>Distribución de Usuarios</h3>
            <canvas id="usuariosChart" height="200"></canvas>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="table-card">
            <h3 class="mb-3"><i class="fa-solid fa-chart-bar me-2"></i>Estado de Ofertas</h3>
            <canvas id="ofertasChart" height="200"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Gráfico de evolución mensual
const ctx = document.getElementById('evolucionChart').getContext('2d');
const evolucionChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($meses->map(fn($m) => \Carbon\Carbon::createFromFormat('Y-m', $m)->format('M Y'))) !!},
        datasets: [
            {
                label: 'Usuarios',
                data: {!! json_encode(array_values($usuariosPorMes->toArray())) !!},
                borderColor: '#10b981',
                backgroundColor: 'rgba(16,185,129,0.1)',
                fill: true,
                tension: 0.3
            },
            {
                label: 'Empresas',
                data: {!! json_encode(array_values($empresasPorMes->toArray())) !!},
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59,130,246,0.1)',
                fill: true,
                tension: 0.3
            },
            {
                label: 'Ofertas',
                data: {!! json_encode(array_values($ofertasPorMes->toArray())) !!},
                borderColor: '#f59e42',
                backgroundColor: 'rgba(245,158,66,0.1)',
                fill: true,
                tension: 0.3
            },
            {
                label: 'Aplicaciones',
                data: {!! json_encode(array_values($aplicacionesPorMes->toArray())) !!},
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99,102,241,0.1)',
                fill: true,
                tension: 0.3
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' },
            title: { display: false }
        },
        interaction: {
            intersect: false,
            mode: 'index'
        }
    }
});

// Gráfico de distribución de usuarios
const usuariosCtx = document.getElementById('usuariosChart').getContext('2d');
const usuariosChart = new Chart(usuariosCtx, {
    type: 'doughnut',
    data: {
        labels: ['Activos', 'Inactivos'],
        datasets: [{
            data: [{{ $usuariosActivos }}, {{ $usuariosInactivos }}],
            backgroundColor: ['#10b981', '#f59e42'],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const total = {{ $usuariosCount }};
                        const percentage = ((context.parsed / total) * 100).toFixed(1);
                        return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                    }
                }
            }
        }
    }
});

// Gráfico de estado de ofertas
const ofertasCtx = document.getElementById('ofertasChart').getContext('2d');
const ofertasChart = new Chart(ofertasCtx, {
    type: 'bar',
    data: {
        labels: ['Activas', 'Inactivas'],
        datasets: [{
            label: 'Ofertas',
            data: [{{ $ofertasActivas }}, {{ $ofertasInactivas }}],
            backgroundColor: ['#10b981', '#6b7280'],
            borderWidth: 1,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const total = {{ $ofertasCount }};
                        const percentage = ((context.parsed / total) * 100).toFixed(1);
                        return context.parsed + ' ofertas (' + percentage + '%)';
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endpush 