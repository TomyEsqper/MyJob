@extends('layouts.admin')

@section('title', 'Gestión de Ofertas')

@section('page-title', 'Gestión de Ofertas')

@section('content')
<div class="filters-card">
    <h3><i class="fa-solid fa-filter me-2"></i>Filtros de búsqueda</h3>
    <form method="GET" action="/admin/ofertas" class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Buscar</label>
            <input type="text" name="q" class="form-control" placeholder="Título, descripción o ubicación..." value="{{ request('q') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-select">
                <option value="">Todos los estados</option>
                <option value="activa" {{ request('estado') == 'activa' ? 'selected' : '' }}>Activa</option>
                <option value="inactiva" {{ request('estado') == 'inactiva' ? 'selected' : '' }}>Inactiva</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Tipo de contrato</label>
            <select name="tipo_contrato" class="form-select">
                <option value="">Todos los tipos</option>
                <option value="Tiempo completo" {{ request('tipo_contrato') == 'Tiempo completo' ? 'selected' : '' }}>Tiempo completo</option>
                <option value="Medio tiempo" {{ request('tipo_contrato') == 'Medio tiempo' ? 'selected' : '' }}>Medio tiempo</option>
                <option value="Temporal" {{ request('tipo_contrato') == 'Temporal' ? 'selected' : '' }}>Temporal</option>
                <option value="Prácticas" {{ request('tipo_contrato') == 'Prácticas' ? 'selected' : '' }}>Prácticas</option>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-success w-100">
                <i class="fa-solid fa-search me-1"></i> Buscar
            </button>
        </div>
    </form>
</div>

<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3><i class="fa-solid fa-briefcase me-2"></i>Listado de Ofertas</h3>
        <span class="badge bg-success fs-6">{{ $ofertas->total() }} ofertas encontradas</span>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Título</th>
                    <th>Ubicación</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ofertas as $oferta)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="company-logo me-2">
                                    @if($oferta->empleador && $oferta->empleador->empleador && $oferta->empleador->empleador->logo_empresa)
                                        <img src="{{ asset($oferta->empleador->empleador->logo_empresa) }}" alt="Logo" class="img-fluid rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <i class="fa-solid fa-building text-muted"></i>
                                    @endif
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $oferta->empleador->empleador->nombre_empresa ?? 'Sin empresa' }}</div>
                                    <small class="text-muted">{{ $oferta->empleador->nombre_usuario }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold">{{ $oferta->titulo }}</div>
                            <small class="text-muted">{{ Str::limit($oferta->descripcion, 50) }}</small>
                        </td>
                        <td>{{ $oferta->ubicacion }}</td>
                        <td>{{ $oferta->tipo_contrato }}</td>
                        <td>
                            <span class="status-badge {{ $oferta->estado == 'activa' ? 'status-activa' : 'status-inactiva' }}">
                                {{ ucfirst($oferta->estado) }}
                            </span>
                        </td>
                        <td>{{ $oferta->created_at->format('d/m/Y') }}</td>
                        <td>
                            <button class="btn btn-danger btn-action" onclick="eliminarOferta({{ $oferta->id }})" title="Eliminar oferta">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            <button class="btn btn-warning btn-action" onclick="cambiarEstado({{ $oferta->id }})" title="Cambiar estado">
                                <i class="fa-solid fa-toggle-on"></i>
                            </button>
                            <a href="#" class="btn btn-info btn-action" title="Ver detalles">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fa-solid fa-briefcase fa-3x text-muted mb-3 d-block"></i>
                            <h5 class="text-muted">No se encontraron ofertas</h5>
                            <p class="text-muted">Intenta ajustar los filtros de búsqueda.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($ofertas->hasPages())
        <div class="d-flex justify-content-center">
            {{ $ofertas->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function eliminarOferta(ofertaId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/ofertas/${ofertaId}/eliminar`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('¡Eliminado!', 'La oferta ha sido eliminada.', 'success')
                    .then(() => location.reload());
                } else {
                    Swal.fire('Error', 'No se pudo eliminar la oferta.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Ocurrió un error al eliminar la oferta.', 'error');
            });
        }
    });
}

function cambiarEstado(ofertaId) {
    fetch(`/admin/ofertas/${ofertaId}/cambiar-estado`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('¡Actualizado!', 'El estado de la oferta ha sido cambiado.', 'success')
            .then(() => location.reload());
        } else {
            Swal.fire('Error', 'No se pudo cambiar el estado.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Ocurrió un error al cambiar el estado.', 'error');
    });
}
</script>
@endpush 