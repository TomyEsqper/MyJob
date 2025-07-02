@extends('layouts.admin')

@section('title', 'Gestionar Aplicaciones')
@section('page-title', 'Gestionar Aplicaciones')

@section('content')
<div class="admin-users-container">
    <div class="admin-users-header">
        <h1>Gestionar Aplicaciones</h1>
        <div class="search-box">
            <form method="GET" action="/admin/aplicaciones" class="d-flex gap-2">
                <input type="text" name="q" placeholder="Buscar por usuario o oferta..." value="{{ request('q') }}" class="form-control">
                <select name="estado" class="form-select">
                    <option value="">Todos los estados</option>
                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="aceptada" {{ request('estado') == 'aceptada' ? 'selected' : '' }}>Aceptada</option>
                    <option value="rechazada" {{ request('estado') == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                </select>
                <button type="submit" class="btn btn-primary">Buscar</button>
                @if(request('q') || request('estado'))
                    <a href="/admin/aplicaciones" class="btn btn-outline-secondary">Limpiar</a>
                @endif
            </form>
        </div>
    </div>

    <div class="table-card">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-3">
            <h3><i class="fa-solid fa-paper-plane me-2"></i>Listado de Aplicaciones</h3>
            <span class="badge bg-success fs-6">{{ $aplicaciones->total() }} aplicaciones encontradas</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="d-none d-md-table-cell">ID</th>
                        <th>Usuario</th>
                        <th>Oferta</th>
                        <th>Empresa</th>
                        <th>Estado</th>
                        <th class="d-none d-md-table-cell">Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aplicaciones->items() as $aplicacion)
                        <tr>
                            <td class="d-none d-md-table-cell">{{ $aplicacion->id_aplicacion }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-2">
                                        @if($aplicacion->usuario->foto_perfil)
                                            <img src="{{ asset($aplicacion->usuario->foto_perfil) }}" alt="Avatar" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="fa-solid fa-user text-white"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $aplicacion->usuario->nombre_usuario }}</div>
                                        <div class="small text-muted">{{ $aplicacion->usuario->correo_electronico }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $aplicacion->oferta->titulo }}</div>
                                <div class="small text-muted">{{ Str::limit($aplicacion->oferta->descripcion, 40) }}</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="company-logo me-2">
                                        @if($aplicacion->oferta->empleador->empleador && $aplicacion->oferta->empleador->empleador->logo_empresa)
                                            <img src="{{ asset($aplicacion->oferta->empleador->empleador->logo_empresa) }}" alt="Logo" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                        @else
                                            <i class="fa-solid fa-building text-muted"></i>
                                        @endif
                                    </div>
                                    <div class="fw-bold">{{ $aplicacion->oferta->empleador->empleador->nombre_empresa ?? 'Sin empresa' }}</div>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $aplicacion->estado }}">
                                    {{ ucfirst($aplicacion->estado) }}
                                </span>
                            </td>
                            <td class="d-none d-md-table-cell">{{ $aplicacion->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button class="btn btn-primary" onclick="verDetalles({{ $aplicacion->id_aplicacion }})">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button class="btn btn-success" onclick="cambiarEstado({{ $aplicacion->id_aplicacion }}, 'aceptada')">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                    <button class="btn btn-danger" onclick="cambiarEstado({{ $aplicacion->id_aplicacion }}, 'rechazada')">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fa-solid fa-paper-plane display-4 text-muted mb-3"></i>
                                    <h4>No se encontraron aplicaciones</h4>
                                    <p class="text-muted">Intenta ajustar los filtros de búsqueda.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($aplicaciones->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $aplicaciones->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal para ver detalle de aplicación -->
<div class="modal fade" id="detalleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle de Aplicación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detalleContent">
                <!-- Contenido dinámico -->
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function verDetalle(id) {
    // Aquí se cargaría el detalle de la aplicación
    document.getElementById('detalleContent').innerHTML = `
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>
    `;
    
    const modal = new bootstrap.Modal(document.getElementById('detalleModal'));
    modal.show();
    
    // Simular carga de datos
    setTimeout(() => {
        document.getElementById('detalleContent').innerHTML = `
            <div class="alert alert-info">
                <i class="fa-solid fa-info-circle"></i>
                Funcionalidad de detalle en desarrollo
            </div>
        `;
    }, 1000);
}

function cambiarEstado(id, estado) {
    if (confirm(`¿Estás seguro de que quieres ${estado == 'aceptada' ? 'aceptar' : 'rechazar'} esta aplicación?`)) {
        // Aquí se haría la petición AJAX para cambiar el estado
        alert(`Estado cambiado a: ${estado}`);
        location.reload();
    }
}
</script>
@endpush