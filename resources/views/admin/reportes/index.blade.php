@extends('layouts.admin')

@section('title', 'Reportes')
@section('page-title', 'Reportes y Estadísticas')

@section('content')
<div class="dashboard-cards mb-4">
    <div class="card">
        <div class="icon"><i class="fa-solid fa-users"></i></div>
        <div class="label">Usuarios</div>
        <div class="value">{{ $usuariosCount }}</div>
        <div class="small text-muted">Activos: {{ $usuariosActivos }} | Inactivos: {{ $usuariosInactivos }}</div>
    </div>
    <div class="card">
        <div class="icon"><i class="fa-solid fa-building"></i></div>
        <div class="label">Empresas</div>
        <div class="value">{{ $empresasCount }}</div>
        <div class="small text-muted">Verificadas: {{ $empresasVerificadas }} | No verificadas: {{ $empresasNoVerificadas }}</div>
    </div>
    <div class="card">
        <div class="icon"><i class="fa-solid fa-briefcase"></i></div>
        <div class="label">Ofertas</div>
        <div class="value">{{ $ofertasCount }}</div>
        <div class="small text-muted">Activas: {{ $ofertasActivas }} | Inactivas: {{ $ofertasInactivas }}</div>
    </div>
    <div class="card">
        <div class="icon"><i class="fa-solid fa-paper-plane"></i></div>
        <div class="label">Aplicaciones</div>
        <div class="value">{{ $aplicacionesCount }}</div>
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
            <h3 class="mb-3"><i class="fa-solid fa-ranking-star me-2"></i>Top Usuarios Destacados</h3>
            <table class="table table-sm">
                <thead><tr><th>Nombre</th><th>Correo</th><th>Destacado</th><th>Verificado</th></tr></thead>
                <tbody>
                @foreach($topUsuarios as $u)
                    <tr>
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
<div class="row mb-4">
    <div class="col-md-6 mb-4">
        <div class="table-card">
            <h3 class="mb-3"><i class="fa-solid fa-trophy me-2"></i>Top Empresas Verificadas</h3>
            <table class="table table-sm">
                <thead><tr><th>Nombre</th><th>Correo</th><th>Verificada</th></tr></thead>
                <tbody>
                @foreach($topEmpresas as $e)
                    <tr>
                        <td>{{ $e->nombre_usuario }}</td>
                        <td>{{ $e->correo_electronico }}</td>
                        <td>@if($e->verificado)<i class="fa-solid fa-circle-check text-primary"></i>@endif</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="table-card">
            <h3 class="mb-3"><i class="fa-solid fa-briefcase me-2"></i>Top Ofertas con más Aplicaciones</h3>
            <table class="table table-sm">
                <thead><tr><th>Título</th><th>Empresa</th><th>Aplicaciones</th></tr></thead>
                <tbody>
                @foreach($topOfertas as $o)
                    <tr>
                        <td>{{ $o->titulo }}</td>
                        <td>{{ $o->empleador->nombre_usuario ?? '-' }}</td>
                        <td>{{ $o->aplicaciones_count }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
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
        }
    }
});
</script>
@endpush 