@extends('layouts.empleador')

@section('title', 'Estadísticas Empleador')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-4">Panel de Estadísticas</h2>
        </div>
    </div>

    {{-- Tarjetas de estadísticas principales con animación --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Postulaciones</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span class="counter" data-target="{{ $totalPostulaciones }}">0</span>
                            </div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span class="counter" data-target="{{ $ofertasActivas }}">0</span>
                            </div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span class="counter" data-target="{{ $promedioPostulantes }}">0</span>
                            </div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span class="counter" data-target="{{ $aplicacionesAceptadas }}">0</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Gráficas principales con filtros --}}
    <div class="row mb-4">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Evolución Mensual</h6>
                    <div class="dropdown no-arrow">
                        <button class="btn btn-link btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="#" onclick="cambiarPeriodo('3')">Últimos 3 meses</a></li>
                            <li><a class="dropdown-item" href="#" onclick="cambiarPeriodo('6')">Últimos 6 meses</a></li>
                            <li><a class="dropdown-item" href="#" onclick="cambiarPeriodo('12')">Último año</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="graficaEvolucion" height="300"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Estado de Candidatos</h6>
                    <div class="dropdown no-arrow">
                        <button class="btn btn-link btn-sm dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
                            <li><a class="dropdown-item" href="#" onclick="actualizarGraficaCandidatos('porcentaje')">Ver porcentajes</a></li>
                            <li><a class="dropdown-item" href="#" onclick="actualizarGraficaCandidatos('cantidad')">Ver cantidades</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="graficaCandidatos" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Gráficas secundarias con interactividad --}}
    <div class="row mb-4">
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Estado de Ofertas</h6>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-primary active" onclick="cambiarVistaOfertas('pie')">
                            <i class="fas fa-chart-pie"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="cambiarVistaOfertas('bar')">
                            <i class="fas fa-chart-bar"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="graficaOfertas" height="300"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Top Ofertas</h6>
                    <select class="form-select form-select-sm" style="width: auto;" onchange="actualizarTopOfertas(this.value)">
                        <option value="5">Top 5</option>
                        <option value="10">Top 10</option>
                        <option value="all">Todas</option>
                    </select>
                </div>
                <div class="card-body">
                    <canvas id="graficaTopOfertas" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla de top ofertas con búsqueda y filtros --}}
    @if($topOfertas->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Top Ofertas con Más Aplicaciones</h6>
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control form-control-sm" id="searchOfertas" placeholder="Buscar oferta...">
                        <select class="form-select form-select-sm" id="filterEstado">
                            <option value="">Todos los estados</option>
                            <option value="activa">Activas</option>
                            <option value="inactiva">Inactivas</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tablaOfertas" width="100%" cellspacing="0">
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
                                        <span class="badge bg-{{ $oferta->estado == 'activa' ? 'success' : 'secondary' }}">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animación de contadores
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 1500;
        const increment = target / (duration / 16);
        let current = 0;

        const updateCount = () => {
            if (current < target) {
                current += increment;
                counter.innerText = Math.round(current);
                requestAnimationFrame(updateCount);
            } else {
                counter.innerText = target;
            }
        };

        updateCount();
    });

    // Configuración de colores y estilos comunes
    const colors = {
        primary: '#4e73df',
        success: '#1cc88a',
        info: '#36b9cc',
        warning: '#f6c23e',
        danger: '#e74a3b',
        secondary: '#858796',
        light: '#f8f9fc'
    };

    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            tooltip: {
                backgroundColor: 'rgba(255, 255, 255, 0.8)',
                titleColor: '#6e707e',
                titleFont: { weight: 'bold' },
                bodyColor: '#858796',
                bodyFont: { size: 14 },
                borderColor: '#dddfeb',
                borderWidth: 1,
                padding: 16,
                displayColors: true,
                callbacks: {
                    label: function(context) {
                        let label = context.dataset.label || '';
                        if (label) {
                            label += ': ';
                        }
                        if (context.parsed.y !== null) {
                            label += context.parsed.y;
                        }
                        return label;
                    }
                }
            }
        }
    };

    // Gráfica de Evolución Mensual
    const ctxEvolucion = document.getElementById('graficaEvolucion');
    const graficaEvolucion = new Chart(ctxEvolucion, {
        type: 'line',
        data: {
            labels: @json(array_column($estadisticasMensuales, 'mes')),
            datasets: [{
                label: 'Aplicaciones',
                data: @json(array_column($estadisticasMensuales, 'aplicaciones')),
                borderColor: colors.primary,
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                tension: 0.3,
                fill: true
            }, {
                label: 'Ofertas Publicadas',
                data: @json(array_column($estadisticasMensuales, 'ofertas')),
                borderColor: colors.success,
                backgroundColor: 'rgba(28, 200, 138, 0.05)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });

    // Gráfica de Estado de Candidatos
    const ctxCandidatos = document.getElementById('graficaCandidatos');
    const graficaCandidatos = new Chart(ctxCandidatos, {
        type: 'doughnut',
        data: {
            labels: ['Pendientes', 'Aceptados', 'Rechazados'],
            datasets: [{
                data: [
                    {{ $aplicacionesPendientes }},
                    {{ $aplicacionesAceptadas }},
                    {{ $aplicacionesRechazadas }}
                ],
                backgroundColor: [colors.warning, colors.success, colors.danger],
                borderColor: colors.light,
                borderWidth: 2
            }]
        },
        options: {
            ...commonOptions,
            cutout: '60%',
            plugins: {
                ...commonOptions.plugins,
                tooltip: {
                    ...commonOptions.plugins.tooltip,
                    callbacks: {
                        label: function(context) {
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value * 100) / total).toFixed(1);
                            return `${context.label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Gráfica de Estado de Ofertas
    const ctxOfertas = document.getElementById('graficaOfertas');
    const graficaOfertas = new Chart(ctxOfertas, {
        type: 'pie',
        data: {
            labels: ['Activas', 'Inactivas'],
            datasets: [{
                data: [{{ $ofertasActivas }}, {{ $ofertasInactivas }}],
                backgroundColor: [colors.success, colors.secondary],
                borderColor: colors.light,
                borderWidth: 2
            }]
        },
        options: {
            ...commonOptions,
            plugins: {
                ...commonOptions.plugins,
                tooltip: {
                    ...commonOptions.plugins.tooltip,
                    callbacks: {
                        label: function(context) {
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value * 100) / total).toFixed(1);
                            return `${context.label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Gráfica de Top Ofertas
    const ctxTopOfertas = document.getElementById('graficaTopOfertas');
    if (ctxTopOfertas && @json($topOfertas->count()) > 0) {
        const graficaTopOfertas = new Chart(ctxTopOfertas, {
            type: 'bar',
            data: {
                labels: @json($topOfertas->pluck('titulo')->map(fn($t) => \Illuminate\Support\Str::limit($t, 25))),
                datasets: [{
                    label: 'Nº de Aplicaciones',
                    data: @json($topOfertas->pluck('aplicaciones_count')),
                    backgroundColor: colors.info,
                    borderRadius: 4
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    },
                    x: {
                        ticks: {
                            autoSkip: false,
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                },
                plugins: {
                    ...commonOptions.plugins,
                    legend: { display: false }
                }
            }
        });
    }

    // Funciones para interactividad
    window.cambiarPeriodo = function(meses) {
        fetch(`{{ route('empleador.estadisticas.mensuales') }}?meses=${meses}`)
            .then(response => response.json())
            .then(data => {
                graficaEvolucion.data.labels = data.labels;
                graficaEvolucion.data.datasets[0].data = data.aplicaciones;
                graficaEvolucion.data.datasets[1].data = data.ofertas;
                graficaEvolucion.update();
            })
            .catch(error => console.error('Error:', error));
    };

    window.actualizarGraficaCandidatos = function(tipo) {
        if (tipo === 'porcentaje') {
            graficaCandidatos.options.plugins.tooltip.callbacks.label = function(context) {
                const value = context.parsed;
                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                const percentage = ((value * 100) / total).toFixed(1);
                return `${context.label}: ${percentage}%`;
            };
        } else {
            graficaCandidatos.options.plugins.tooltip.callbacks.label = function(context) {
                return `${context.label}: ${context.parsed}`;
            };
        }
        graficaCandidatos.update();
    };

    window.cambiarVistaOfertas = function(tipo) {
        graficaOfertas.config.type = tipo;
        graficaOfertas.update();
        
        // Actualizar estado de los botones
        const buttons = document.querySelectorAll('[onclick^="cambiarVistaOfertas"]');
        buttons.forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
    };

    window.actualizarTopOfertas = function(cantidad) {
        fetch(`{{ route('empleador.estadisticas.top-ofertas') }}?cantidad=${cantidad}`)
            .then(response => response.json())
            .then(data => {
                graficaTopOfertas.data.labels = data.labels;
                graficaTopOfertas.data.datasets[0].data = data.data;
                graficaTopOfertas.update();
            })
            .catch(error => console.error('Error:', error));
    };

    // Búsqueda y filtrado de tabla
    const searchInput = document.getElementById('searchOfertas');
    const filterSelect = document.getElementById('filterEstado');
    const tabla = document.getElementById('tablaOfertas');

    if (searchInput && filterSelect && tabla) {
        const filtrarTabla = () => {
            const searchTerm = searchInput.value.toLowerCase();
            const filterValue = filterSelect.value.toLowerCase();
            const rows = tabla.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            Array.from(rows).forEach(row => {
                const titulo = row.cells[0].textContent.toLowerCase();
                const estado = row.cells[1].textContent.toLowerCase();
                const matchSearch = titulo.includes(searchTerm);
                const matchFilter = !filterValue || estado.includes(filterValue);
                row.style.display = matchSearch && matchFilter ? '' : 'none';
            });
        };

        searchInput.addEventListener('input', filtrarTabla);
        filterSelect.addEventListener('change', filtrarTabla);
    }
});
</script>
@endsection
