@extends('layouts.empleador')

@section('title', 'Estadísticas Empleador')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-4">Panel de Estadísticas</h2>
        </div>
    </div>

    {{-- Tarjetas de estadísticas principales --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Postulaciones</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="contadorPostulaciones">{{ $totalPostulaciones }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Ofertas Activas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="contadorOfertas">{{ $ofertasActivas }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-briefcase fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Promedio por Oferta</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $promedioPostulantes }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Candidatos Aceptados</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $aplicacionesAceptadas }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Gráficas principales --}}
    <div class="row mb-4">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Evolución Mensual</h6>
                </div>
                <div class="card-body">
                    <canvas id="graficaEvolucion"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Estado de Candidatos</h6>
                </div>
                <div class="card-body">
                    <canvas id="graficaCandidatos"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Gráficas secundarias --}}
    <div class="row mb-4">
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Estado de Ofertas</h6>
                </div>
                <div class="card-body">
                    <canvas id="graficaOfertas"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Top Ofertas</h6>
                </div>
                <div class="card-body">
                    <canvas id="graficaTopOfertas"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla de top ofertas --}}
    @if($topOfertas->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top 5 Ofertas con Más Aplicaciones</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Estado</th>
                                    <th>Aplicaciones</th>
                                    <th>Fecha de Publicación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topOfertas as $oferta)
                                <tr>
                                    <td>{{ $oferta->titulo }}</td>
                                    <td>
                                        <span class="badge badge-{{ $oferta->estado == 'activa' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($oferta->estado) }}
                                        </span>
                                    </td>
                                    <td>{{ $oferta->aplicaciones_count }}</td>
                                    <td>{{ $oferta->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Contadores Animados ---
        function animarContador(id, valorFinal, duracion = 1500) {
            const elemento = document.getElementById(id);
            if (!elemento) return;
            
            let inicio = 0;
            const incremento = valorFinal / (duracion / 15);

            const intervalo = setInterval(() => {
                inicio += incremento;
                if (inicio >= valorFinal) {
                    inicio = valorFinal;
                    clearInterval(intervalo);
                }
                elemento.textContent = Math.ceil(inicio);
            }, 15);
        }

        animarContador('contadorPostulaciones', {{ $totalPostulaciones }});
        animarContador('contadorOfertas', {{ $ofertasActivas }});

        // --- Gráficas Chart.js ---
        Chart.defaults.font.family = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.color = '#858796';

        // Gráfica de Evolución Mensual
        const ctxEvolucion = document.getElementById('graficaEvolucion');
        if (ctxEvolucion) {
            new Chart(ctxEvolucion.getContext('2d'), {
                type: 'line',
                data: {
                    labels: @json(array_column($estadisticasMensuales, 'mes')),
                    datasets: [{
                        label: 'Aplicaciones',
                        data: @json(array_column($estadisticasMensuales, 'aplicaciones')),
                        borderColor: '#4e73df',
                        backgroundColor: 'rgba(78, 115, 223, 0.05)',
                        tension: 0.3,
                        fill: true
                    }, {
                        label: 'Ofertas Publicadas',
                        data: @json(array_column($estadisticasMensuales, 'ofertas')),
                        borderColor: '#1cc88a',
                        backgroundColor: 'rgba(28, 200, 138, 0.05)',
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
                    plugins: { legend: { display: true, position: 'bottom' } }
                }
            });
        }

        // Gráfica de Estado de Candidatos
        const ctxCandidatos = document.getElementById('graficaCandidatos');
        if (ctxCandidatos) {
            new Chart(ctxCandidatos.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: @json(array_keys($estadosCandidatos)),
                    datasets: [{
                        data: @json(array_values($estadosCandidatos)),
                        backgroundColor: ['#f6c23e', '#1cc88a', '#e74a3b'],
                        borderColor: '#ffffff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: true, position: 'bottom' },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += context.parsed;
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Gráfica de Estado de Ofertas
        const ctxOfertas = document.getElementById('graficaOfertas');
        if (ctxOfertas) {
            new Chart(ctxOfertas.getContext('2d'), {
                type: 'pie',
                data: {
                    labels: @json(array_keys($estadosOfertas)),
                    datasets: [{
                        data: @json(array_values($estadosOfertas)),
                        backgroundColor: ['#1cc88a', '#858796'],
                        borderColor: '#ffffff',
                        borderWidth: 2
                    }]
                },
                 options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: true, position: 'bottom' }
                    }
                }
            });
        }

        // Gráfica de Top Ofertas
        const ctxTopOfertas = document.getElementById('graficaTopOfertas');
        if (ctxTopOfertas && @json($topOfertas->count()) > 0) {
            new Chart(ctxTopOfertas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: @json($topOfertas->pluck('titulo')->map(fn($t) => \Illuminate\Support\Str::limit($t, 25))),
                    datasets: [{
                        label: 'Nº de Aplicaciones',
                        data: @json($topOfertas->pluck('aplicaciones_count')),
                        backgroundColor: '#36b9cc'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { 
                        y: { beginAtZero: true, ticks: { precision: 0 } },
                        x: { ticks: { autoSkip: false, maxRotation: 45, minRotation: 45 } }
                    },
                    plugins: { legend: { display: false } }
                }
            });
        }
    });
</script>
@endsection
